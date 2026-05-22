<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

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

        return redirect()->back()->with('success', 'Announcement successfully made!');

    }

    public function destroy(Announcement $announcement){
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }
}
