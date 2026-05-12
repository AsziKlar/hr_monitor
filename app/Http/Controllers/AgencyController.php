<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request){
        $agencies = Agency::query();
        $fieldOffices = FieldOffice::All();

        if($request->filled('fieldOffice')){
            $agencies->where('field_office_id', $request->fieldOffice);
        }

        if ($request->filled('search')) {

            $agencies->where('name', 'like', '%' . $request->search . '%');
        }

        $agencies = $agencies->get();

        return view('admin.agencies', compact('agencies', 'fieldOffices'));
    }

    public function store(Request $request){

        $mechanisms = Mechanism::All();

        $request->validate([
            'email_address' => 'required|email|unique:agencies,email_address',
        ]);

        $agency = Agency::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'head' => $request->head,
            'email_address' => $request->email_address,
            'field_office_id' => $request->field_office_id
        ]);

        foreach ($mechanisms as $mechanism) {
            AgencyMechanismPeriod::create([
                'agency_id' => $agency->id,
                'mechanism_id' => $mechanism->id,
                'current_perid' => 1
            ]);
        }
       

        return redirect()->back();
    }

    public function show(Agency $agency){
        $fieldOffices = FieldOffice::All();
        $mechanisms = Mechanism::All();
        $drafts =  collect();

        foreach($mechanisms as $mechanism){ 
            $period = AgencyMechanismPeriod::where('agency_id', $agency->id)
                                            ->where('mechanism_id', $mechanism->id)
                                            ->first();

            $latestDraft = Draft::where('agency_id', $agency->id)
                                    ->where('mechanism_id', $mechanism->id)
                                    ->where('period', $period->current_period)
                                    ->latest()
                                    ->first();
            
            if ($latestDraft) {
                $drafts->push($latestDraft);
            }

        }

        
        return view('admin.agency', compact('agency','fieldOffices', 'drafts'));
    }

    public function update(Request $request, Agency $agency){
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:20',
            'field_office_id' => 'required|exists:field_offices,id',
            'email_address' => 'required|email',
            'head' => 'required|string|max:255',
        ]);

        $agency->update([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'field_office_id' => $request->field_office_id,
            'email_address' => $request->email_address,
            'head' => $request->head,
        ]);

        return back()->with('success', 'Agency updated successfully!');
    }
}
