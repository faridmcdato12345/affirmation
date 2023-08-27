<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    public function delete(Request $request) {
        $user = $request->user();
        if (Hash::check($request->password, $user->password)) {
            $user->delete();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return view('auth.login');
        } else {
            return view('settings', ['active' => 'settings'])->withErrors(['msg' => 'The provided password does not match.']);
        }
    }

    public function getAffirmation(Request $request)
    {
        return Auth::user()->getAffirmation();
    }

    public function show()
    {
        return Inertia::render('Setting/Account', ['user' => Auth::user()]);
    }

    public function switchBackground(User $user, Request $request)
    {
        $user->update([
            'background_image' => $request->img
        ]);

        return back()->with('success', 'Image has been switched successfully!');
    }

    public function uploadUserImage(ImageUploadRequest $request)
    {
        $user = auth()->user()->loadCount('backgroundImages');

        if($user->background_images_count > 9) {
            return back()->with('error', 'You\'ve reached the amount of images allowed for each user');
        }

        try {
            DB::beginTransaction();
            $image = Storage::disk('public')->put(auth()->id(), $request->validated('image'));

            UserBackground::create([
                'user_id' => auth()->id(),
                'image' => Storage::disk('public')->url($image) 
            ]);

            DB::commit();
        } catch(\Exception $exception) {
            return back()->with('error', 'Something went wrong in uploading your image.');
        }

        return back()->with('success', 'Image has been uploaded successfully!');
    } 

    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());
    }

    public function accountabilityPartner()
    {
        return Inertia::render('Setting/AccountabilityPartner');
    }
}
