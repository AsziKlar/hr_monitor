<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Comment;
use App\Models\Draft;
use App\Models\Mechanism;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DraftController extends Controller
{
    public function mechanism_filter(){
        $mechanisms = Mechanism::All();

        return view('mechanisms', compact('mechanisms'));
    }

    public function status_filter($mechanism){
        $statuses = Status::All();

        return view('admin.statuses', compact('statuses','mechanism'));
    }
    // public function index_by_status(Status $status, Mechanism $mechanism){
    //     $drafts = Draft::where('mechanism_id', $mechanism->id)
    //                     ->where('status_id', $status->id)
    //                     ->get();
    //     return view('admin.index', compact('drafts'));
        
    // }

    public function index_hrmo(Request $request, Mechanism $mechanism){
        $user = auth()->user();

        $drafts = Draft::where('mechanism_id', $mechanism->id);

        $latestDraft = null;

       
        $period = AgencyMechanismPeriod::where('agency_id', $user->agency_id)
                    ->where('mechanism_id', $mechanism->id)
                    ->first();

        $drafts = $drafts   ->where('agency_id', $user->agency_id)
                            ->where('period', $period->current_period)->latest()->get();
        
        $latestDraft = Draft::where('agency_id', $user->agency_id)
                        ->where('mechanism_id', $mechanism->id)
                        ->where('period', $period->current_period)
                        ->latest('id')
                        ->first();                   

        return view('drafts.index', compact('drafts', 'mechanism', 'latestDraft'));
    }

    public function index_admin(Request $request, Mechanism $mechanism){
        $drafts = Draft::query()
            ->select('drafts.*')
            ->join('agency_mechanism_periods', function ($join) use ($mechanism) {
                $join->on('drafts.agency_id', '=', 'agency_mechanism_periods.agency_id')
                    ->where('agency_mechanism_periods.mechanism_id', $mechanism->id)
                    ->whereColumn('drafts.period', 'agency_mechanism_periods.current_period');
            })
            ->where('drafts.mechanism_id', $mechanism->id);

        if ($request->filled('status')) {
            $drafts->where('drafts.status_id', $request->status);
        }

        $drafts = $drafts
            ->latest('drafts.id')
            ->get()
            ->unique('agency_id')
            ->values();

        return view('admin.index', compact('drafts', 'mechanism'));
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
        $comments = Comment::where('draft_id', $id)->get();

        $draft = Draft::with('status')->find($id);

        $latestDraft = Draft::where('agency_id', $draft->agency_id)
                        ->where('mechanism_id', $draft->mechanism_id)
                        ->where('period', $draft->period)
                        ->latest('id')
                        ->first();

        // //for the frontend either to show Edit button or not.
        // $canEdit =  $latestDraft && 
        //             $latestDraft->id === $draft->id &&
        //             $draft->status->name === 'To be Reviewed' &&
        //             $draft->agency_id === $user->agency_id;

        return view('drafts.show', compact('draft', 'comments', 'user'));
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

   public function updateFile(Request $request, Draft $draft){

        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($draft->file_path && Storage::disk('public')->exists($draft->file_path)) {
            Storage::disk('public')->delete($draft->file_path);
        }

        $path = $request->file('file')->store('drafts', 'public');

        $draft->update([
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Draft file replaced successfully.');
    }

   
}
