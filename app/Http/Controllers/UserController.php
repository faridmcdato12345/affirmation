<?php

namespace App\Http\Controllers;

use App\Helpers\BrevoSubscription;
use App\Http\Requests\PartnerInviteRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Traits\ConvertTimeZone;
use App\Models\AccountabilityPartner;
use App\Models\AccountabilityPartnerNotification;
use App\Models\AppVersion;
use App\Models\AppVersionList;
use App\Models\Reminder;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    use ConvertTimeZone;

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

        Reminder::create([
            'original_time' => now()->format('H:i'),
            'custom_message' => $request->message,
            'user_id' => $request->user_id,
            'reminder_type' => 'reminder',
            'time' => now()->format('H:i'),
            'timezone' => auth()->user()->timezone
        ]);

        return back()->with('success', 'A reminder has been sent successfully!');
    }

    public function markAsRead(AccountabilityPartnerNotification $reminder)
    {
        $reminder->update(['seen_at' => now()]);
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
    
    public function getUserAppVersion($userId)
    {
        try {
            $user = User::select('id','app_update_trigger')->where('id',$userId)->first();
            if($user['app_update_trigger'] == 0){
                return response()->json(['status' => false]);
            }
            $appVersion = AppVersion::latest()->first();
            $appDesc = AppVersionList::select('app_version_id','description')->where('app_version_id',$appVersion->id)->get();
            return response()->json([
                'status' => true,
                'version_number' => $appVersion->version_number,
                'list' => $appDesc
            ]);    
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function updateUserTrigger($id)
    {
        try {
            $user = User::where('id',$id)->update(['app_update_trigger' => 0]);
            return response()->json(['status' => true]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
   
    public function updateAppNotif()
    {
        try {
            DB::beginTransaction();
            auth()->user()->update([
                'app_notifications_subscription' => !auth()->user()->app_notifications_subscription
            ]);
            $this->updateBrevoSubscription();
            DB::commit();
            return back()->with('success', 'App notification subscription has been updated');
        } catch(Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ', $e->getMessage());
        }
    }

    public function updateNewsLetter()
    {
        try {
            DB::beginTransaction();
            auth()->user()->update([
                'newsletter_subscription' => !auth()->user()->newsletter_subscription
            ]);
            $this->updateBrevoSubscription();
            DB::commit();
            return back()->with('success', 'App notification subscription has been updated');
        } catch(Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ', $e->getMessage());
        }
    }

    private function updateBrevoSubscription()
    {
        $unlinkIds = [];
        $listIds = [];
        $user = auth()->user();

        !$user->app_notifications_subscription ? $unlinkIds[] = 5 : $listIds[] = 5;
        !$user->newsletter_subscription ? $unlinkIds[] = 6 : $listIds[] = 6;

        //Subscribe to Brevo List
        $brevo = new BrevoSubscription();
        $brevo->updateSubIds($user->email, $unlinkIds, $listIds);
    }
}
