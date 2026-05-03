<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name'];
    public function drafts(){
        return $this->hasMany(Draft::class);
    }
}
