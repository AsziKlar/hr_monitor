<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function index(){

    }

    public function create(){

    }

    public function store(){
        $request->validate([
            'mechanism_id' => 'required|exists:mechanisms,id',
            'file' => 'required|file|mimes:pdf|max:10240',
            'period' => 'nullable|string|max:50'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('drafts', 'public');

        $status = Status::where('name', 'To be Reviewed')->first();

        Draft::create([
            'mechanism_id' => $request->mechanism_id,
            'user_id' => $auth()->id(),
            'agency_id' => auth()->user()->agency_id,
            'status_id' => $status->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'period' => $request->period,
        ]);

        return redirect()   ->route('drafts.index')
                            ->with('success', 'Draft submitted successfully!');
    }

}
