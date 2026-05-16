<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Mechanism;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;

class AgencyMechanismPeriodController extends Controller
{
    public function mechanism_filter(){
        $mechanisms = Mechanism::all();

        return view('admin.settings-mechanism', compact('mechanisms'));
    }
    public function agency_filter(Mechanism $mechanism){
        $agencies = Agency::all();

        return view('admin.settings-agency', compact('agencies', 'mechanism'));

    }

    public function period_increment(Mechanism $mechanism, Agency $agency){
        $approved = Status::where('name', 'Approved')->first()->id;

        $current_period_of_drafts_to_be_deleted = AgencyMechanismPeriod::where('mechanism_id', $mechanism->id)
                                                ->where('agency_id', $agency->id)
                                                ->first();


        $drafts = Draft::where('mechanism_id', $mechanism->id)
                        ->where('agency_id', $agency->id)
                        ->where('period', $current_period_of_drafts_to_be_deleted->current_period)
                        ->where('status_id', '!=',  $approved)
                        ->get();

        foreach ($drafts as $draft) {
            $draft->delete();
        }


        $current_period = AgencyMechanismPeriod::where('agency_id', $agency->id)
                                        ->where('mechanism_id', $mechanism->id)
                                        ->first();

        $current_period->increment('current_period');

        return redirect()->back();

    }

}
