<?php

namespace App\Http\Controllers;

use App\Models\AgencyMechanismPeriod;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index_hrmo(Request $request){
        $user = auth()->user();
        $agency_id = $user->agency_id;
        $mechanisms = Mechanism::all();
        $latest_draft_per_mechanism = [];
        $period = AgencyMechanismPeriod::where('agency_id', $agency_id) //for the recent submissions
                                        ->value('current_period'); 

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
        
        $latestSubmissions = Draft::where('agency_id', $agency_id) //for the recent submission
                                ->where('period', $period)
                                ->where('created_at', '>=', now()->subMonth())
                                ->latest()
                                ->get();

        $latestAnnouncement = Announcement::latest()->first();

        return view('dashboard', compact('mechanisms','latest_draft_per_mechanism', 'latestSubmissions','latestAnnouncement'));

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


        $field_office_names = [];
        $field_office_counts = [];

        $fieldOffices = FieldOffice::with('agencies')->get();

        foreach ($fieldOffices as $fieldOffice) {
            $field_office_names[] = $fieldOffice->name;
            $completedAgenciesCount = 0;

            foreach ($fieldOffice->agencies as $agency){
                $approvedMechanismsCount = 0;

                foreach ($mechanisms as $mechanism){
                    $period = AgencyMechanismPeriod::where('agency_id', $agency->id)
                                                        ->where('mechanism_id', $mechanism->id)
                                                        ->value('current_period');

                    $latestDraft = Draft::where('agency_id', $agency->id)
                                            ->where('mechanism_id', $mechanism->id)
                                            ->where('period', $period)
                                            ->latest()
                                            ->first();
                    if ($latestDraft && $latestDraft->status->id == 3) {
                        $approvedMechanismsCount++;
                    }

                }

                if ($approvedMechanismsCount == $mechanisms->count()){
                    $completedAgenciesCount++;
                }
                
            }
            $field_office_counts[] = $completedAgenciesCount;
        }
        

        return view('dashboard', compact('mechanisms', 'drafts_to_be_reviewed', 'drafts_approved', 'to_be_reviewed_count', 'approved_count','total_drafts_num', 'drafts', 'field_office_names', 'field_office_counts'));
    }
}
