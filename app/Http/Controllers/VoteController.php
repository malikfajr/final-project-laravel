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
        'message' => "Silahkan Login Dulu"
      ]);
    }
  }

  public function vote(Request $req) {
      $key["user_id"] = Auth::user()->id;
      $post_id = $req->input('id');
      $value = $req->input('vote');
      if (! $this->dislikeValidation() && $value == 'dislike') {
        return response()->json(['ok' => false, 'message' => 'Point anda kurang dari 15!']);
      }

      if ($req->input('type') == 'question') {
        $key['question_id'] = $post_id;
        $vote = Votes::updateOrCreate($key, ["vote" => $value]);
        $this->setPoint(Question::find($post_id)->user_id, $req->input('vote'));

      }elseif ($req->input('type') == 'answer') {
        $key['answer_id'] = $post_id;
        $vote = Votes::updateOrCreate($key, ["vote" => $value]);
        $this->setPoint(Answer::find($post_id)->user_id, $req->input('vote'));

      }else {
        return "error vote";
      }

      $data['ok'] = true;
      $data['data'] = $vote;
      return response()->json($data);
  }

  public function setPoint($user_id, $vote){
    $point = Reputation::firstOrCreate(["user_id" => $user_id]);
    if ($vote == 'like') {
      $point->update(["point" => $point->point += 10]);
    }elseif ($vote == 'dislike') {
      $point->update(["point" => $point->point -= 1]);
    }
  }
  public function dislikeValidation()
  {
    $user_id = Auth::id();
    $point = Reputation::where('user_id', "=", $user_id)->first();
    try {
      if ($point->point < 15) {
        return false;
      }
    } catch (\Exception $e) {
      return false;
    }
    return true;
  }
}
