<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersionList extends Model
{
    use HasFactory;

    protected $fillable = ['description','app_version_id'];

    public function app_versions()
    {
        return $this->belongsTo(AppVersion::class);
    }
}
