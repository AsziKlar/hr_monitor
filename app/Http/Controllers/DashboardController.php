<?php

namespace App\Http\Controllers;

use App\Models\AgencyMechanismPeriod;
use App\Models\Announcement;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index_hrmo(Request $request){
        $user = auth()->user();
        $statuses = Status::all();
        $agency_id = $user->agency_id;
        $mechanisms = Mechanism::all();
        $latest_draft_per_mechanism = [];

        foreach ($mechanisms as $mechanism) { //for the overview cards
            $period = AgencyMechanismPeriod::where('agency_id', $agency_id)
                                            ->where('mechanism_id', $mechanism->id)
                                            ->value('current_period');

            $latestDraft = Draft::where('agency_id', $agency_id)
                            ->where('mechanism_id', $mechanism->id)
                            ->where('period', $period)
                            ->latest()
                            ->first();

            $latest_draft_per_mechanism[$mechanism->id] = $latestDraft;
        }
        
        $currentPeriods = AgencyMechanismPeriod::where('agency_id', $agency_id)
            ->pluck('current_period', 'mechanism_id');

        $latestSubmissions = Draft::where('agency_id', $agency_id)
            ->where('created_at', '>=', now()->subMonth())
            ->where('status_id', 1)
            ->latest()
            ->get()
            ->filter(function ($draft) use ($currentPeriods) {

                return isset($currentPeriods[$draft->mechanism_id])

                    && $draft->period == $currentPeriods[$draft->mechanism_id];

            });

        $latestAnnouncement = Announcement::latest()->first();
        
        return view('dashboard', compact('mechanisms','latest_draft_per_mechanism', 'latestSubmissions','latestAnnouncement'));

    }
    
    public function index_admin(){
       

        return view('dashboard');
    }
}
