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
        'head',
        'abbreviation',
        'photo',
        'archived_at'
    ];

    public function fieldOffice(){
        return $this->belongsTo(FieldOffice::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function drafts(){
        return $this->hasMany(Draft::class);
    }
    public function agencyMechanismPeriods(){
        return $this->hasMany(AgencyMechanismPeriod::class);
    }
    public function scopeNotArchived($query){
        return $query->whereNull('archived_at');
    }
}
