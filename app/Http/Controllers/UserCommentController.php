<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{


    public function __construct()
    {
        return $this->middleware('auth')->only(['store']);
    }

    public function store(StoreComment $request, User $user)
    {
        $user->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id
        ]);
        return redirect()->back();
    }
}
