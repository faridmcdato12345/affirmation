<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerInviteRequest;
use App\Models\AccountabilityPartner;
use App\Models\ExerciseResult;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AccountabilityPartnerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PartnerInviteRequest $request)
    {
        $user = User::where('email', $request->email)->first(); 

        //Check if email is the same with the authenticated user
        if($user->email === auth()->user()->email) {
            return redirect('/')->with('info', 'You cannot send an invite to your self');
        }

        DB::beginTransaction();
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
            DB::commit();
            if($parterInvite->wasRecentlyCreated) {
                return redirect('/')->with('success', 'Invite has been sent successfully!');
            }
        } catch(Exception $e) {
            DB::rollback();
            return redirect('/')->with('error', $e->getMessage());
        }

        return redirect('/')->with('success', 'An invite has been sent already');
    }

    private function sendPartnerInvite($email)
    {
        
    }
}
