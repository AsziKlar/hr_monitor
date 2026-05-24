<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;
use App\Models\Mechanism;
use App\Models\Status;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;

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

        $user = User::where('agency_id', $agency->id)->first();

        $user->notify(
            new SystemNotification(
                'Your submission for ' . $mechanism->description . ' has been reset. Submit new drafts for ' . $mechanism->description,
                route('hrmo.drafts.index', $mechanism)
            )
        );

        return redirect()->back()->with('success', 'Period updated. New batch of drafts for this mechanism.');
    }

    public function period_increment_all(Mechanism $mechanism){
        $agencies = Agency::all();
        $approved = Status::where('name', 'Approved')->first()->id;

        foreach ($agencies as $agency) {
            $agencyMechanismPeriod = AgencyMechanismPeriod::where('agency_id', $agency->id)
                                                            ->where('mechanism_id', $mechanism->id)
                                                            ->first();

            $current_period = $agencyMechanismPeriod->current_period;

            Draft::where('agency_id', $agency->id)
                    ->where('mechanism_id', $mechanism->id)
                    ->where('period', $current_period)
                    ->where('status_id','!=', $approved)
                    ->delete();
           
            $agencyMechanismPeriod->increment('current_period');
           
            $user = User::where('agency_id', $agency->id)->first();
            if ($user) {
                $user->notify(
                    new SystemNotification(
                        'Your submission for ' . $mechanism->description . ' has been reset. Submit new drafts for ' . $mechanism->description,
                         route('hrmo.drafts.index', $mechanism)
                    )
                );
            }
        }

        return redirect()->back()->with('success', 'Period updated for all agencies. New batch of drafts for all agencies in this mechanism');
    }

}