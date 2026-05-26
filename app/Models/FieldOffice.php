<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldOffice extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];
    public function agencies(){
        return $this->hasMany(Agency::class);
    }
}
