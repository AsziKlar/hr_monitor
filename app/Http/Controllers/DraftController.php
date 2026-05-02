<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draft;
use App\Models\Status;
use App\Models\User;

class DraftController extends Controller
{

    public function index($mechanism_id){
        $user = auth()->user();

        $drafts = Draft::where('mechanism_id', $mechanism_id);

        if ($user->role->name === 'HRMO') {
            $drafts = $drafts->where('agency_id', $user->agency_id)->get();
        } else {
            $drafts = $drafts->get();
        }

        return view('drafts.index', compact('drafts'));
    }

    public function create(){

    }

    public function store(Request $request){
        $user = auth()->user();

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
            'user_id' => $user->id,
            'agency_id' => $user->agency_id,
            'status_id' => $status->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'period' => $request->period,
        ]);

        return redirect()   ->route('drafts.index')
                            ->with('success', 'Draft submitted successfully!');
    }

}
