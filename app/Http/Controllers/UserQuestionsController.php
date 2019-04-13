<?php

namespace App\Http\Controllers;

use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class UserQuestionsController extends Controller
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
        $user = Auth::user();
//        $questionsTest = Question::all();
        $userQuestions = $user->questions()->paginate(6);

        // dd($questions);
//        dd($questionsTest);
        //dd($questions);
//        $questionsTest = $this->paginate($questionsTest);
        return view('userQuestions')->with('userQuestions', $userQuestions);
    }


}
