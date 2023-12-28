<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->encryptAttributes($user);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $this->encryptAttributes($user);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    protected function encryptAttributes(User $user)
    {
        $attributesToEncrypt = collect($user->getAttributes())->except([
            'password',
            'email_verified_at',
            'remember_token',
            'trial_end_at',
            'created_at',
            'updated_at',
            'fcm_token',
            'isNotify',
            'show_introduction',
            'app_update_trigger',
            'active_category_id',
            'timezone'
            ])->toArray();

        foreach($attributesToEncrypt as $key => $value){
            $user->$key = Crypt::encrypt($value);
        }
    }
}
