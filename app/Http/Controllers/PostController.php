<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostSentence;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user:id,name')->latest()->paginate(10);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        $post = new Post([
            'user_id' => auth()->id(),
            'title' => $request->get('title'),
            'text' => $request->get('text'),
        ]);

        $post->save();

        // Divide the post text into sentences
        $sentences = preg_split('/(?<=[.!?])\s+/', $post->text, -1, PREG_SPLIT_NO_EMPTY);

        // Create PostSentence records for each sentence
        foreach ($sentences as $index => $sentenceText) {
            $sentence = new PostSentence([
                'post_id' => $post->id,
                'sentence_number' => $index + 1,
                'text' => trim($sentenceText),
            ]);
            $sentence->save();
        }

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = Post::with([
            'user:id,name',
            'sentences:id,post_id,sentence_number,text',
            'corrections:id,post_id,user_id',
            'corrections.user:id,name',
            'corrections.correctionSentences:id,correction_id,post_sentence_id,corrected_text,explanation'
        ])->find($post->id);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
