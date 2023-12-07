<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private  Comment $comment;

    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    public function store(Request $request) {
        try {
            $requestValidate = $request->validate([
                'comment' => 'required',
                'user_id' => 'required',
                'post_id' => 'required'
            ]);
            $this->comment->create($requestValidate);
            return redirect()->back()->with('success', 'Komentar Berhasil diunggah!');
        }
        catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id) {
        $this->comment->find($id)->delete();
        return redirect()->back()->with('success', 'Komentar Berhasil dihapus!');
    }
}
