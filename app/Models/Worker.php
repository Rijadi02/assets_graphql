<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function allAssets()
    {
        return $this->belongsToMany(Asset::class)->orderBy('id', 'DESC');
    }

}
