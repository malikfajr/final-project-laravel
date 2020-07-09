<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Votes;
use App\Question;
use App\Answer;
use App\Reputation;

class VoteController extends Controller {
  public function __construct() {
    if (!Auth::check()) {
      return response()->json([
        'ok' => false,
        'msg' => "Silahkan Login Dulu"
      ]);
    }
  }

  public function vote(Request $req) {
      $key["user_id"] = Auth::user()->id;
      $post_id = $req->input('id');
      $value = $req->input('vote')

      if ($req->input('type') == 'question') {
        $key['question_id'] = $post_id;
        $vote = Votes::updateOrCreate($key, ["vote" => $value]);

        setPoint(Question::find($post_id)->user_id, $req->input('vote'));
      }elseif ($req->input('type') == 'answer') {
        $key['answer_id'] = $post_id;
        $vote = Votes::updateOrCreate($key, ["vote" => $value]);

        setPoint(Answer::find($post_id)->user_id, $req->input('vote'));
      }else {
        return "error vote";
      }

      $data['ok'] = true;
      $data['data'] = $vote;
      return response()->json($data);
  }

  private function setPoint($user_id, $vote){
    if ($vote == 'like') {
      // $reputation = Reputation::
    }
  };
}
