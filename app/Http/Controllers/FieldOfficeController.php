<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\FieldOffice;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;

class FieldOfficeController extends Controller
{
    public function field_office_index(Request $request) {

        $all_field_offices = FieldOffice::all();

        $agencies_with_no_field_office = Agency::whereNUll('field_office_id')->get();
   
        $field_offices = FieldOffice::with('agencies');
       
        if($request->filled('search')){
            $field_offices->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('agencies', function ($query) use ($request){
                                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $field_offices = $field_offices->get();



        return view('admin.field-office', compact('field_offices', 'all_field_offices', 'agencies_with_no_field_office'));    
    }

    public function field_office_update(Request $request, Agency $agency){
        $new_field_office_id = $request->field_office_id;

        $agency->update([
            'field_office_id' =>  $new_field_office_id
        ]);

        $new_field_office = FieldOffice::find($new_field_office_id);    

        $user = User::where('agency_id', $agency->id)->first();

        $user?->notify(
            new SystemNotification(
                'You have been re-assigned to ' . $new_field_office->name . ' field office',
                route('agency.profile.show')
            )
        );

        return redirect()->back()->with('success', 'Field office changed successfully!');
    }

    public function field_office_add(Request $request){
        $request->validate([
            'field_office_name' => 'required|string'
        ]);

        FieldOffice::create([
            'name' => $request->field_office_name
        ]);

        return redirect()->back()->with('success', 'Added new field office successfully');
    }
    public function add_agency(Request $request, FieldOffice $fieldOffice){
        
        $agency = Agency::findOrFail($request->agency);
        $agency->update([
            'field_office_id' => $fieldOffice->id
        ]);
        return redirect()->back()->with('success', 'Successfully assigned');
    }
    public function field_office_destroy(Request $request){
        $fieldOffice = FieldOffice::findOrFail($request->fieldOffice);

        $fieldOffice->delete();

        return redirect()->back()->with('success', 'Field office removed successfully');
    }
    
}