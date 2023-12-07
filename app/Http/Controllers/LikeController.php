<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Exception;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private Like $like;

    public function __construct(Like $like) {
        $this->like = $like;
    }

    public function like(Request $request) {
        try {
            $requestValidate = $request->validate([
                'user_id' => 'required',
                'post_id' => 'required',
                'liked' => 'required'
            ]);
            $this->like->create($requestValidate);
            return redirect()->back()->with('success', 'Disukai!');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
