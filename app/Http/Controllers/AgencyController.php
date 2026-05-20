<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        
        
        
        if ($path = $request->file('photo')){
            $path->store('photos', 'public');
        }

        $agency = Agency::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'head' => $request->head,
            'email_address' => $request->email_address,
            'field_office_id' => $request->field_office_id,
            'photo' => $path

        ]);

        foreach ($mechanisms as $mechanism) {
            AgencyMechanismPeriod::create([
                'agency_id' => $agency->id,
                'mechanism_id' => $mechanism->id,
                'current_period' => 1
            ]);
        }
       

        return redirect()->back()->with('success', 'Agency added successfully');
    }

    public function show(Agency $agency){
        $fieldOffices = FieldOffice::All();
        $mechanisms = Mechanism::All();
        $drafts =  collect();
        $approvedCount = 0;
        $agency_hrmo = User::where('agency_id', $agency->id)->first();

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
                if ($latestDraft->status->name == "Approved"){
                    $approvedCount++;

                }
            }

        }

        
        return view('admin.agency', compact('agency','fieldOffices', 'drafts','approvedCount', 'agency_hrmo'));
    }

    public function update(Request $request, Agency $agency){
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:20',
            'field_office_id' => 'required|exists:field_offices,id',
            'email_address' => 'required|email',
            'head' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'field_office_id' => $request->field_office_id,
            'email_address' => $request->email_address,
            'head' => $request->head,
        ];

        if ($request->hasFile('photo')){
            if ($agency->photo && Storage::disk('public')->exists($agency->photo)){
                Storage::disk('public')->delete($agency->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');

            $data['photo']=$path;
        }      

        $agency->update($data);




        return back()->with('success', 'Agency updated successfully!');
    }

    public function show_profile() {
        $field_offices = FieldOffice::all();

        $user = auth()->user();

        $agency = Agency::where('id', $user->agency->id)->first();

        return view('hrmo.profile', compact('user', 'agency', 'field_offices'));
    }

    public function update_profile(Request $request) {
        $agency = auth()->user()->agency;
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:20',
            'field_office_id' => 'required|exists:field_offices,id',
            'email_address'=> 'required|email',
            'head' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'field_office_id' => $request->field_office_id,
            'email_address' => $request->email_address,
            'head' => $request->head        
        ];

        if($agency->head !== $request->head) {
            AgencyMechanismPeriod::where('agency_id', $agency->id)
                                    ->increment('current_period');
            
        }

        if ($request->hasFile('photo')){
            if($agency->photo && Storage::disk('public')->exists($agency->photo)){
                Storage::disk('public')->delete($agency->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');

            $data['photo']=$path;
        }
        $agency->update($data);
        return redirect()->back()->with('success', 'Updated profile successfully');
    }

    
}
