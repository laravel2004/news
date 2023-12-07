<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{

    private Post $post;
    private Comment $comment;
    private Like $like;

    public function __construct(Post $post, Comment $comment, Like $like) {
        $this->post = $post;
        $this->comment = $comment;
        $this->like = $like;
    }

    public function index()
    {
        $posts = $this->post->all();
        return view('dashboard', compact('posts'));
    }

    public function postSelf() {
        $posts = $this->post->where('user_id', auth()->user()->id)->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $requestValidate = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'slug' => 'required',
                'user_id' => 'required'
            ]);

            $image = $request->file('image');
            $image->storeAs('public/post', $image->hashName());

            $this->post->create([
                'title' => $requestValidate['title'],
                'content' => $requestValidate['content'],
                'image' => $image->hashName(),
                'slug' => $requestValidate['slug'],
                'user_id' => $requestValidate['user_id']
            ]);
            return redirect()->route('post.self')->with('success', 'Berita Berhasil diunggah!');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->post->find($id);
        $comments = $this->comment->where('post_id', $id)->get();
        $likes = $this->like->where('post_id', $id)->count();
        return view('posts.show', compact('post', 'comments', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = $this->post->find($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $requestValidate = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'nullable',
                'slug' => 'required',
                'user_id' => 'required'
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/post', $image->hashName());
                $this->post->find($id)->update([
                    'title' => $requestValidate['title'],
                    'content' => $requestValidate['content'],
                    'image' => $image->hashName(),
                    'slug' => $requestValidate['slug'],
                    'user_id' => $requestValidate['user_id']
                ]);
                return redirect()->route('post.self')->with('success', 'Berita Berhasil diubah!');
            }

            $this->post->find($id)->update([
                'title' => $requestValidate['title'],
                'content' => $requestValidate['content'],
                'slug' => $requestValidate['slug'],
                'user_id' => $requestValidate['user_id']
            ]);

            return redirect()->route('post.self')->with('success', 'Berita Berhasil diubah!');

        }
        catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->post->find($id)->delete();
        return redirect()->route('post.self')->with('success', 'Berita Berhasil dihapus!');
    }
}
