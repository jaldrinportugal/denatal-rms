<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PatientCommentController extends Controller
{
    
    public function addComment(Request $request, $communityforumId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->communityforum_id = $communityforumId;
        $comment->comment = $request->comment;
        $comment->save();
    
        return redirect()->route('patient.communityforum')->with('success', 'Comment added successfully.');
    }
    
    public function editComment($id)
    {
        $comment = Comment::findOrFail($id);
        session()->flash('edit_comment_id', $id);
        return redirect()->route('patient.communityforum');
    }
    
    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $comment = Comment::findOrFail($id);
        $comment->comment = $request->comment;
        $comment->save();
    
        return redirect()->route('patient.communityforum')->with('success', 'Comment updated successfully.');
    }
    
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    
        return redirect()->route('patient.communityforum')->with('success', 'Comment deleted successfully.');
    }
}
