<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyMechanismPeriod extends Model
{
    protected $fillable = [
        'agency_id',
        'mechanism_id',
        'current_period'
    ];
    public function agency(){
        return $this->belongsTo(Agency::class);
    }

    public function mechanism(){
        return $this->belongsTo(Mechanism::class);
    }
}
