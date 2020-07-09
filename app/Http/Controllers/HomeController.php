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
        //$answers = $questions->users()->get();
        $anwers="";
      return view('welcome', compact('questions','anwers'));
        
    }
    

    public function showtag($id){
        $questions = Question::where('tag','like','%' .$id .'%')->get();
       // dd($questions);
        return view('welcome')
                  ->with(compact('questions'));
      }
}
