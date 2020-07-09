<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

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
        $questions = Question::all();
        $answers="";
       // $answers = $questions->users()->get();
       // dd($answers);
      return view('welcome', compact('questions','answers'));
        
    }
    

    public function showtag($id){
        $questions = Question::where('tag','like','%' .$id .'%')->get();
       // dd($questions);
        return view('welcome')
                  ->with(compact('questions'));
      }
}
