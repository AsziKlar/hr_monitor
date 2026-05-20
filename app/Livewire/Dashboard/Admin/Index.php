<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use Livewire\Component;

class Index extends Component
{
    public $mechanisms;

    public $drafts_to_be_reviewed = [];
    public $drafts_approved = [];
    public $to_be_reviewed_count = [];
    public $approved_count = [];
    public $total_drafts_num = [];

    public $drafts;

    public $field_office_names = [];
    public $field_office_counts = [];

    public function mount()
    {
        $this->loadDashboard();
    }

    public function loadDashboard()
    {
        $this->mechanisms = Mechanism::all();

        $this->drafts_to_be_reviewed = [];
        $this->drafts_approved = [];
        $this->to_be_reviewed_count = [];
        $this->approved_count = [];
        $this->total_drafts_num = [];

        foreach ($this->mechanisms as $mechanism) {
            $latestDrafts = Draft::query()
                ->select('drafts.*')
                ->join('agency_mechanism_periods', function ($join) use ($mechanism) {
                    $join->on('drafts.agency_id', '=', 'agency_mechanism_periods.agency_id')
                        ->where('agency_mechanism_periods.mechanism_id', $mechanism->id)
                        ->whereColumn('drafts.period', 'agency_mechanism_periods.current_period');
                })
                ->where('drafts.mechanism_id', $mechanism->id)
                ->latest('drafts.id')
                ->get()
                ->unique('agency_id')
                ->values();

            $this->total_drafts_num[$mechanism->id] = $latestDrafts->whereIn('status_id', [1, 2, 3])->count();

            $this->to_be_reviewed_count[$mechanism->id] = $latestDrafts->where('status_id', 1)->count();
            $this->drafts_to_be_reviewed[$mechanism->id] = $latestDrafts->where('status_id', 1);

            $this->approved_count[$mechanism->id] = $latestDrafts->where('status_id', 3)->count();
            $this->drafts_approved[$mechanism->id] = $latestDrafts->where('status_id', 3);
        }

        $this->drafts = Draft::where('status_id', 1)
            ->oldest()
            ->take(10)
            ->get();

        $this->field_office_names = [];
        $this->field_office_counts = [];

        $fieldOffices = FieldOffice::with('agencies')->get();

        foreach ($fieldOffices as $fieldOffice) {
            $this->field_office_names[] = $fieldOffice->name;

            $completedAgenciesCount = 0;

            foreach ($fieldOffice->agencies as $agency) {
                $approvedMechanismsCount = 0;

                foreach ($this->mechanisms as $mechanism) {
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

                if ($approvedMechanismsCount == $this->mechanisms->count()) {
                    $completedAgenciesCount++;
                }
            }

            $this->field_office_counts[] = $completedAgenciesCount;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.admin.index');
    }
}

