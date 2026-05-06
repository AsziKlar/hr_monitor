<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field_office_id',
        'email_address',
        'head'
    ];

    public function fieldOffice(){
        return $this->belongsTo(FieldOffice::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function drafts(){
        return $this->hasMany(Draft::class);
    }
    public function agencyMechanismPeriods(){
        return $this->hasMany(AgencyMechanismPeriod::class);
    }
}
