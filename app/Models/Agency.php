<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    public function fieldOffice(){
        return $this->belongsTo(FieldOffice::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function drafts(){
        return $this->hasMany(Draft::class);
    }
}
