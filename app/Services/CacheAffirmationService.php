<?php

namespace App\Services;

use App\Models\Affirmation;
use App\Models\UserAffirmation;
use Illuminate\Support\Facades\Cache;

class CacheAffirmationService {

    public function getAffirmations(): Object
    {
        return Cache::rememberForever('affirmations', function () {
            return Affirmation::all();
        });
    }

    public function getUserAffirmations(): Object
    {
        return  Cache::rememberForever('userAffirmations', function () {
            return UserAffirmation::all();
        });
    }
}