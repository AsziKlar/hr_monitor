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

        Announcement::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $user->id
        ]);

        return redirect()->back();

    }

    public function view(){
        
    }
}
