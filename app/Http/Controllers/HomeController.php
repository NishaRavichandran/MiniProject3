<?php

namespace App\Http\Controllers;

use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function index(Request $request)
    {
        $user = Auth::user();
        $questionsTest = Question::all();
       // $questionsTest->sortByDesc('created_at');
        //$questionsTest = $questionsTest->sortByDesc('created_at');
        $sort = $request->input('sort');
        if($sort==null)
            $sorted = $questionsTest->sortByDesc('created_at');
        else
            $sorted = $questionsTest->sortByDesc('created_at');
        $sorted = $questionsTest->sortByDesc($sort);
        $questionsTest = $sorted->values()->all();


        //$questions = $user->questions()->paginate(6);

        $questionsTest = $this->paginate($questionsTest);
        return view('home')->with('questions', $questionsTest);
    }


    public function paginate($items, $perPage = 9, $page = null,
                             $baseUrl = "/home",
                             $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ?
            $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage),
            $items->count(),
            $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }
}
