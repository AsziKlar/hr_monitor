<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Draft extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'mechanism_id',
        'user_id',
        'agency_id',
        'status_id',
        'period',
        'file_name',
        'file_path'
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
