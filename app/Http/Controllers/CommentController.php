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

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    public function update(Request $request, Comment $comment){
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment->update([
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully');
    }

    public function destroy(Comment $comment){
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }
}
