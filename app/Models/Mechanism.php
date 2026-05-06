<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanism extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];
    public function drafts(){
        return $this->hasMany(Draft::class);
    }
    public function agencyMechanismPeriods(){
        return $this->hasMany(AgencyMechanismPeriod::class);
    }
}
