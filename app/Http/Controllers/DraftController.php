<?php

namespace App\Http\Controllers;

use App\Models\AgencyMechanismPeriod;
use Illuminate\Http\Request;
use App\Models\Draft;
use App\Models\Status;
use App\Models\User;
use App\Models\Mechanism;


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
        return view('drafts.create', compact('mechanism'));
    }

    public function store(Request $request){
        $user = auth()->user();

        $request->validate([
            'mechanism_id' => 'required|exists:mechanisms,id',
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('drafts', 'public');

        $status = Status::where('name', 'To be Reviewed')->first();

        $period = AgencyMechanismPeriod::where('agency_id', $user->agency_id)
                    ->where('mechanism_id', $request->mechanism_id)
                    ->first();

        if (!$period) {
            return back()->with('error', 'No period has been opened for this mechanism yet.');
        }

        Draft::create([
            'mechanism_id' => $request->mechanism_id,
            'user_id' => $user->id,
            'agency_id' => $user->agency_id,
            'status_id' => $status->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'period' => $request->current_period,
        ]);

        return redirect()   ->route('drafts.index')
                            ->with('success', 'Draft submitted successfully!');
    }

}
