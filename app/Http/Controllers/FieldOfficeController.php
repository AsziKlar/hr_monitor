<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FieldOffice;
use App\Models\Agency;

class FieldOfficeController extends Controller
{
    public function field_office_index(Request $request) {
        $field_offices = FieldOffice::with('agencies');
        
        if($request->filled('search')){
            $field_offices->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('agencies', function ($query) use ($request){
                                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $field_offices = $field_offices->get();

        return view('admin.field-office', compact('field_offices'));
        

    }
}
