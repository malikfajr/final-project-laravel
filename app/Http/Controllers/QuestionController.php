<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Question;
use App\User;
use App\Reputation;
use App\Models\QuestionModel;

class QuestionController extends Controller
{
    public function __construct() {
      // return $this->middleware('auth');
    }

    public function store(Request $req) {
      $question = new Question;
      $question->title = $req->input('title');
      $question->content = $req->input('content');
      $question->id = uniqid("Q-");
      $question->user_id = Auth::id();
      $question->tag = $req->input('tag');

      $question->save();
      $data['ok'] = true;
      $data['data'] = $question;
      return response()->json($data);
    }

    public function update(Request $req, $id) {
      $question = Question::find($id);
      $question->title = $req->input('title');
      $question->content = $req->input('content');
      $question->tag = $req->input('tag');
      if ($req->input('user_id') == Auth::user()->id) {
        $question->save();
        $data['ok'] = true;
        $data['data'] = $question;
      }else {
        $data['ok'] = false;
        $data['error'] = "Maaf, anda bukan pembuat pertanyan.";
      }
      return response()->json($data);
    }

    public function destroy($question_id) {
      $question = Question::find($question_id);
      $user_create = $question->user_id;
      if ($user_create == Auth::id()) {
        $question->delete();
        return response()->json(["ok" => true, "msg" => "Berhasil menghapus"]);
      }else {
        return response()->json(["ok" => false, "msg" => "Maaf, anda bukan pembuat pertanyan"]);
      }
    }
    public function solved(Request $req)
    {
      $question_id = $req->input('question_id');
      $answer_id = $req->input('answer_id');
      $question = Question::find($question_id);
      $question->solved = $answer_id;

      $answer = $question->answer()->where("id", "=", $answer_id)->first();
      $point = $this->solvePoint($answer->user_id);

      $question->save();
      return json_encode(['ok' => true, 'data' => $question]);
    }
    public function solvePoint($user_id)
    {
      $point = Reputation::firstOrCreate(["user_id" => $user_id]);
      $point->update(["point" => $point->point += 15]);

      return $point;

    }
    //view controller

    public function index() {
      $questions = Question::all();
      return view('pages.question.index', compact('questions'));
    }
    public function create() {
      return view('pages.question.create');
    }


    public function show($id) {
      $user_id = Auth::id();
      $question = QuestionModel::QuestionDetail($user_id, $id);
      $answers =  QuestionModel::AnswersDetail($user_id, $id);
      if (!$question) {
        return redirect('/question');
      }
      return view('pages.question.show')
                ->with(compact('question','answers'));
    }
    public function edit($id) {
      $question = Question::find($id);
      return view('pages.question.edit', compact('question'));
    }
}
