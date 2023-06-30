<?php

namespace App\Models\Setting;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAffirmation extends Model
{
    use HasFactory;

    protected $guarded;

    protected $table = 'user_affirmations';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function storeOwnAffirmation($request)
    {
        try {
            $affirmations = $request['affirmation'];
            $affirmationArr = [];
            foreach ($affirmations as $affirmation) {
                if(empty($affirmation)){
                    continue;
                }
                array_push($affirmationArr,['affirmation'=>Str::of($affirmation)->trim()]);
            }
            
            $user = Auth::user();
            $userData = $user->user_affirmation()->createMany($affirmationArr);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $userData;
    }
}
