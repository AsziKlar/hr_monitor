<?php

namespace App\Http\Controllers;

use App\Models\AgencyMechanismPeriod;
use Illuminate\Http\Request;
use App\Models\Draft;
use App\Models\Mechanism;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index_hrmo(Request $request){
        $user = auth()->user();
        
        $agency_id = $user->agency_id;

        $mechanisms = Mechanism::all();

        $drafts_per_mechanism = [];

        foreach ($mechanisms as $mechanism) {
            $period = AgencyMechanismPeriod::where('agency_id', $agency_id)
                                            ->where('mechanism_id', $mechanism->id)
                                            ->value('current_period');

            $drafts = Draft::where('agency_id', $agency_id)
                            ->where('mechanism_id', $mechanism->id)
                            ->where('period', $period)
                            ->get();

            $drafts_per_mechanism[$mechanism->name] = $drafts;
        }

        return view('index_hrmo', compact('drafts_per_mechanism'));

    }
}
