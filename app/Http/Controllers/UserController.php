<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\PartnerInviteRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AccountabilityPartner;
use App\Models\AccountabilityPartnerNotification;
use App\Models\User;
use App\Models\UserBackground;
use Exception;
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
        $accountabilityPartner = AccountabilityPartner::personalInvite()->with(['requestedUser:id,name,email', 'requestedUser.accountabilityReminders'])->get();
        $accountabilityRequest = AccountabilityPartner::partnerRequest()->with(['requestingUser:id,name,email', 'requestingUser.affirmationStatus'])->get();
    
        return Inertia::render('Setting/AccountabilityPartner', compact('accountabilityPartner', 'accountabilityRequest'));
    }

    public function approveInvite(AccountabilityPartner $partner)
    {
        $partner->update([
            'accepted_at' => now()
        ]);

        return back()->with('success', 'Invite has been accepted');
    }

    public function deleteInvite(AccountabilityPartner $partner)
    {
        $partner->delete();
        return back()->with('success', 'Invite sent has been cancelled');
    }

    public function remindPartner(Request $request)
    {
        AccountabilityPartnerNotification::create([
            'message' => $request->message,
            'user_id' => $request->user_id,
            'partner_id' => auth()->id()
        ]);

        return back()->with('success', 'A reminder has been sent successfully!');
    }

    public function markAsRead(AccountabilityPartnerNotification $reminder)
    {
        $reminder->update([
            'seen_at' => now()
        ]);

        return back()->with('success', 'Reminder has been marked as read');
    }

    public function sendInvite(PartnerInviteRequest $request)
    {        
        $user = User::where('email', $request->email)->first(); 

        //Check if email is the same with the authenticated user
        if($user->email === auth()->user()->email) {
            return back()->with('info', 'You cannot send an invite to your self');
        }

        try {
            $parterInvite = AccountabilityPartner::firstorCreate([
                    ...$request->validated(),
                    'user_id' => $user->id, 
                    'inviter_id' => auth()->id() 
                ],
                [
                    ...$request->validated(),
                    'inviter_id' => auth()->id(),
                ]
            );

            if($parterInvite->wasRecentlyCreated) {
                return back()->with('success', 'Invite has been sent successfully!');
            }
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'An invite has been sent already');
    }

    public function hideIntroduction()
    {
        auth()->user()->update([
            'show_introduction' => false
        ]);

        return back()->with('success', 'Introduction has been hidden at startup successfully!');
    }

    public function showIntroduction()
    {
        auth()->user()->update([
            'show_introduction' => true
        ]);

        return back()->with('success', 'Introduction has been shown at startup successfully!');
    }
}
