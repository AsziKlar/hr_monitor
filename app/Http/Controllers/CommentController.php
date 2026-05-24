<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Draft;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id){
        $user = auth()->user();

        $request->validate([
            'comment' => 'required|string',
        ]);

        $draft = Draft::with('user', 'mechanism')->findOrFail($id);

        $comment = Comment::create([
            'comment' => $request->comment,
            'draft_id' => $draft->id,
            'user_id' => $user->id,
        ]);

        if ($user->role->id == 4) {

            $commentUsers = $draft->comments()
                                    ->with('user')
                                    ->get()
                                    ->pluck('user')
                                    ->filter()
                                    ->where('id', '!=', $user->id)
                                    ->unique('id');

            foreach ($commentUsers as $commentUser) {
                $commentUser->notify(
                    new SystemNotification(
                        $user->agency->name . ' commented on the draft for ' . $draft->mechanism->description,
                        route('drafts.show', $draft->id)
                    )
                );
            }
        } else {
           
            $draft->user?->notify(
                new SystemNotification(
                    $user->name . ' commented on your draft in ' . $draft->mechanism->description,
                    route('drafts.show', $draft->id)
                )
            );
        }

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