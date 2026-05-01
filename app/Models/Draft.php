<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    public function mechanism(){
        return $this->belongsTo(Mechanism::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function agency(){
        return $this->belongsTo(Agency::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
