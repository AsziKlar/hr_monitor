<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldOffice extends Model
{
    public function agencies(){
        return $this->hasMany(Agency::class);
    }
}
