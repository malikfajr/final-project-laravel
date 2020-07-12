<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionModel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions = QuestionModel::all(Auth::id());

      return view('welcome', compact('questions'));

    }


    public function showtag($id){
        $questions = QuestionModel::byTag(Auth::id(), $id);
       // dd($questions);
        return view('welcome')
                  ->with(compact('questions'));
      }
}
