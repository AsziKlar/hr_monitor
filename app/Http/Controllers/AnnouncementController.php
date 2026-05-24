<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(){
        $announcements = Announcement::all();

        return view('announcements', compact('announcements'));
    }

    public function store(Request $request){
        $user = auth()->user();

        $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:255'
        ]);
      
        Announcement::create([
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
       
        return redirect()->back()->with('success', 'Announcement successfully made!');
    }

    public function destroy(Announcement $announcement){
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }
}