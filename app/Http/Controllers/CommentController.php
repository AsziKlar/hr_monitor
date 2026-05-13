<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id){
        $user = auth()->user()->id;

        $request->validate([
            'comment' => 'required'
        ]);
        
        Comment::create([
            'comment' => $request->comment,
            'draft_id' => $id,
            'user_id' => $user
        ]);

        return redirect()->back()->with('success', 'Draft submitted successfully!');
    }
}
