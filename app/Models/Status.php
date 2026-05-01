<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function drafts(){
        return this->hasMany(Draft::class);
    }
}
