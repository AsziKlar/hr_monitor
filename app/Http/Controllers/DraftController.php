<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use Illuminate\Http\Request;
use App\Models\Draft;
use App\Models\Status;
use App\Models\User;
use App\Models\Mechanism;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage; 

class DraftController extends Controller
{
    public function mechanism_filter(){
        $mechanisms = Mechanism::All();

        return view('mechanisms', compact('mechanisms'));
    }

    public function index($mechanism_id){
        $user = auth()->user();

        $drafts = Draft::where('mechanism_id', $mechanism_id);

        $latestDraft = null;

        if ($user->role->name === 'HRMO') {

            $period = AgencyMechanismPeriod::where('agency_id', $user->agency_id)
                        ->where('mechanism_id', $mechanism_id)
                        ->first();

            $drafts = $drafts   ->where('agency_id', $user->agency_id)
                                ->where('period', $period->current_period)->latest()->get();
            
             $latestDraft = Draft::where('agency_id', $user->agency_id)
                                ->where('mechanism_id', $mechanism_id)
                                ->where('period', $period->current_period)
                                ->latest('id')
                                ->first();                   

            
        } else {
            $drafts = $drafts->latest()->get();
        }

        return view('drafts.index', compact('drafts', 'mechanism_id', 'latestDraft'));
    }

    public function create($mechanism){
        
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
            'period' => $period->current_period,
            'description' => $request->description
        ]);

        return redirect()   ->back()
                            ->with('success', 'Draft submitted successfully!');
    }

    public function show($id) {
        $user = auth()->user();

        $draft = Draft::with('status')->find($id);

        $latestDraft = Draft::where('agency_id', $draft->agency_id)
                        ->where('mechanism_id', $draft->mechanism_id)
                        ->where('period', $draft->period)
                        ->latest('id')
                        ->first();

        //for the frontend either to show Edit button or not.
        $canEdit =  $latestDraft && 
                    $latestDraft->id === $draft->id &&
                    $draft->status->name === 'To be Reviewed' &&
                    $draft->agency_id === $user->agency_id;

        return view('drafts.show', compact('draft', 'canEdit'));
    }

    public function approve($id){
        $draft = Draft::find($id);
        $draft->status_id = 3;
        $draft->save();
        return back();
    }
    public function revision($id){
        $draft = Draft::find($id);
        $draft->status_id = 2;
        $draft->save();
        return back();
    }

    public function updateFile(Request $request, $id){
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240'
        ]);

        $draft = Draft::find($id);

        Storage::disk('public')->delete($draft->file_path);

        $path = $request->file('file')->store('drafts', 'public');
        $draft->file_path = $path;
        $draft->file_name=$request->file('file')->getClientOriginalName();

        $draft->save();

        return back();

    }

}
