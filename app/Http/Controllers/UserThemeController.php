<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\UserBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserThemeController extends Controller
{
    public function uploadUserImage(ImageUploadRequest $request)
    {
        if(!auth()->user()->subscribed()) {
            return back()->withErrors(['error' => 'You need to subscribe to premium to upload custom backgrounds.']); 
        }

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
    
    public function deleteUserImage(UserBackground $background) 
    {
        try {
            DB::beginTransaction();
            
            Storage::disk('public')->delete($background->image);
            $background->delete();
            
            DB::commit();
        } catch(\Exception $exception) {
            return back()->with('error', 'Something went wrong');
        }

        return back()->with('success', 'Image has been deleted successfully!!');
    }
}
