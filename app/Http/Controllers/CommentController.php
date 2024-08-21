<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view('comment.index', [
            'comments' =>Comment::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->comments()->create($validated);



        return redirect(route('comments.index'));
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment,Request $request):View
    {
        Gate::authorize('update', $comment);


        return view('comment.edit', [
            'comments' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);


        
        $comment->update($validated);
        return redirect(route('comments.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment):RedirectResponse
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect(route('comments.index'));
    }
}
