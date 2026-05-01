<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function draft(){

        return $this->belongsTo(Draft::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
