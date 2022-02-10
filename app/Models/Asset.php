<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function history(){
        return $this->BelongsToMany(Worker::class)->withTimestamps();;

    }
}
