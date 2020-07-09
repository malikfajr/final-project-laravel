<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Answer;

class AnswerController extends Controller
{
    public function __construct() {
      return $this->middleware('auth');
    }

    public function store(Request $req, $question_id) {
      $comment = Answer::create([
        "id" => uniqid("A-"),
        "question_id" => $question_id,
        "content" => $req->input('content'),
        "user_id" => Auth::user()->id
      ]);
      return redirect('question/' . $question_id);
    }
}
