<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FieldOffice;
use App\Models\Agency;

class FieldOfficeController extends Controller
{
    public function field_office_index(Request $request) {
        $all_field_offices = FieldOffice::all();
    
        $field_offices = FieldOffice::with('agencies');
        
        if($request->filled('search')){
            $field_offices->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('agencies', function ($query) use ($request){
                                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $field_offices = $field_offices->get();

        return view('admin.field-office', compact('field_offices', 'all_field_offices'));
        

    }

    public function field_office_update(Request $request, Agency $agency){
        $new_field_office_id = $request->field_office_id;

        $agency->update([
            'field_office_id' =>  $new_field_office_id
        ]);

        return redirect()->back();
    }

    public function field_office_add(Request $request){
        $request->validate([
            'field_office_name' => 'required|string|'
        ]);

        FieldOffice::create([
            'name' => $request->field_office_name
        ]);

        return redirect()->back();

    }
}
