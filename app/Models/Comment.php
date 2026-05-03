<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'draft_id',
        'user_id',
        'comment'
    ];
    public function draft(){

        return $this->belongsTo(Draft::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
