<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class Draft extends Model
{

    protected $fillable = [
        'mechanism_id',
        'user_id',
        'status_id',
        'agency_id',
        'file_name',
        'file_path',
        'period',
    ];
    
    
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
