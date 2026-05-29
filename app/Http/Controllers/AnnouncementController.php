<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Announcement;
use App\Models\AuditLog;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(){
        $announcements = Announcement::latest()->get();

        return view('announcements', compact('announcements'));
    }

    public function store(Request $request){
        $user = auth()->user();

        $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:255'
        ]);
      
        $announcement = Announcement::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $user->id
        ]);

        $agencies = Agency::all();

        foreach ($agencies as $agency){
            $agency->user?->notify(
                new SystemNotification(
                    'A new announcement has been posted entitled \'' . $announcement->title . '\' . Click here to visit the dashboard.',
                    route('hrmo.dashboard')
                )
            );
        }

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Admin created announcement entitled ' . $announcement->title,
        ]);
       
        return redirect()->back()->with('success', 'Announcement successfully made!');
    }

    public function destroy(Announcement $announcement){
        $announcement->delete();

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Admin deleted announcement entitled ' . $announcement->title,
        ]);

        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }
}