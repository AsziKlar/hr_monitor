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
    
    public function index_admin(){
        $mechanisms = Mechanism::all();
        $drafts_to_be_reviewed = [];
        $drafts_approved = [];
        $to_be_reviewed_count = [];
        $approved_count = [];
        $total_drafts_num= [];

       
        // this for the piecharts
        foreach ($mechanisms as $mechanism) {
            $period = AgencyMechanismPeriod::where('mechanism_id', $mechanism->id)
                    ->value('current_period');

            $latestDrafts = Draft::where('mechanism_id', $mechanism->id)
                                    ->where('period', $period)
                                    ->latest()
                                    ->get()
                                    ->unique('agency_id');

            $total_drafts_num[$mechanism->id]= $latestDrafts->whereIn('status_id', [1,2,3])->count();
            
            $to_be_reviewed_count[$mechanism->id] = $latestDrafts->where('status_id', 1)->count();
            $drafts_to_be_reviewed[$mechanism->id] = $latestDrafts->where('status_id', 1);

            $approved_count[$mechanism->id] = $latestDrafts->where('status_id', 3)->count();
            $drafts_approved[$mechanism->id] = $latestDrafts->where('status_id', 3);

            
        }

       
         $drafts = Draft::where('status_id', 1)
                            ->oldest()
                            ->take(10)
                            ->get();
        

        return view('dashboard', compact('mechanisms', 'drafts_to_be_reviewed', 'drafts_approved', 'to_be_reviewed_count', 'approved_count','total_drafts_num', 'drafts'));
    }
}
