<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\FieldOffice;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request){
        $agencies = Agency::query();
        $fieldOffices = FieldOffice::All();

        if($request->filled('fieldOffice')){
            $agencies->where('field_office_id', $request->fieldOffice);
        }

        $agencies = $agencies->get();

        return view('admin.agencies', compact('agencies', 'fieldOffices'));
    }

    public function store(Request $request){

        $request->validate([
            'email_address' => 'required|email|unique:agencies,email_address',
        ]);

        Agency::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'head' => $request->head,
            'email_address' => $request->email_address,
            'field_office_id' => $request->field_office_id
        ]);

        return redirect()->back();
    }

}
