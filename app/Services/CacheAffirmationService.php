<?php

namespace App\Services;

use App\Models\Affirmation;
use Illuminate\Support\Facades\Cache;

class CacheAffirmationService {

    public function getData(): Object
    {
        return Cache::rememberForever('affirmations',function(){
            return Affirmation::all();
        });
    }
}