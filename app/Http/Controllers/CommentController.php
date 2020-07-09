<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller {
  public function __construct() {
    if (!Auth::check()) {
      return response()->json([
        'ok' => false,
        'msg' => "Silahkan Login Dulu"
      ]);
    }
  }

  public function store(Request $req) {
    $content = $req->input('content');
    $id = $req->input('id');
    $user_id = Auth::user()->id;

    $comment = new Comment;
    $comment->user_id = $user_id;
    $comment->content = $content;
    if (substr($id, 0, 1) == 'Q') {
      $comment->question_id = $id;
    }elseif (substr($id, 0, 1) == 'A') {
      $comment->answer_id = $id;
    }
    $comment->save();
    $data['ok'] = true;
    $data['data'] = $comment;
    return response()->json($data);
  }
}
