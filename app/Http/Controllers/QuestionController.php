<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $question = new Question;
        $edit = FALSE;
        return view('questionForm', ['question' => $question, 'edit' => $edit]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'body' => 'required|min:5',
        ], [

            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',

        ]);
        $input = request()->all();

        $question = new Question($input);
        $question->user()->associate(Auth::user());
        $question->save();

        return redirect()->route('home')->with('message', 'IT WORKS!');


        // return redirect()->route('questions.show', ['id' => $question->id]);

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('question')->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Question $question)
    {
        $edit = TRUE;
        return view('questionForm', ['question' => $question, 'edit' => $edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {

        $input = $request->validate([
            'body' => 'required|min:5',
        ], [

            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',

        ]);

        $question->body = $request->body;
        $question->save();

        return redirect()->route('question.show', ['question_id' => $question->id])->with('message', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('home')->with('message', 'Deleted');

    }

    public function vote(Request $request)
    {
        $userId = $request['userId'];
        $questionsId = $request['questionsId'];
        $voteType = $request['voteType'];
        $token = $request['_token'];

        // query below returns vote_type('up' or 'down') or null
        $vote = DB::table('votes')->where([
            ['user_id', "=", $request['userId']],
            ['questions_id', "=", $request['questionsId']]
        ])->value('vote_type');

        // if user didn't vote
        if (!$vote) {
            DB::table('votes')->insert([
                'questions_id' => $questionsId,
                'user_id' => $userId,
                'vote_type' => $voteType
            ]);
            $questions = Question::find($questionsId);
            if ($voteType == "up") {
                $questionsVotesUp = $questions->votes_up;
                $questionsVotesUp = $questionsVotesUp + 1;
                $questions->votes_up = $questionsVotesUp;
                $questionsVotesDown = $questions->votes_down;
                $result = $questionsVotesUp - $questionsVotesDown;
                $questions->result = $result;
                $questions->update();
            } else {
                $questionsVotesDown = $questions->votes_down;
                $questionsVotesDown = $questionsVotesDown + 1;
                $questions->votes_down = $questionsVotesDown;
                $questionsVotesUp = $questions->votes_up;
                $result = $questionsVotesUp - $questionsVotesDown;
                $questions->result = $result;
                $questions->update();
            }
            $result = $questions->votes_up - $questions->votes_down;
            $up = $questions->votes_up;
            $down = $questions->votes_down;
            return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }
        // if user has already voted
        if ($vote == $voteType) {
            return response()->json(['warning' => 'You can not vote twice(up or down) for same question'], 200);
        } else {
            $questions = Question::find($questionsId);
            if ($voteType == 'up') {
                // update votes field in posts Table
                $questionsVotesDown = $questions->votes_down;
                $questionsVotesDown = $questionsVotesDown - 1;
                $questions->votes_down = $questionsVotesDown;
                $questionsVotesUp = $questions->votes_up;
                $questionsVotesUp = $questionsVotesUp + 1;
                $questions->votes_up = $questionsVotesUp;
                $result = $questionsVotesUp - $questionsVotesDown;
                $questions->result = $result;
                $questions->update();
                DB::table('votes')->where([
                    ['user_id', "=", $request['userId']],
                    ['questions_id', "=", $request['questionsId']]
                ])->update(['vote_type' => $voteType]);
            } else {
                // update votes field in posts Table
                $questionsVotesUp = $questions->votes_up;
                $questionsVotesUp = $questionsVotesUp - 1;
                $questions->votes_up = $questionsVotesUp;
                $questionsVotesDown = $questions->votes_down;
                $postVotesDown = $questionsVotesDown + 1;
                $questions->votes_down = $postVotesDown;
                $result = $questionsVotesUp - $questionsVotesDown;
                $questions->result = $result;
                $questions->update();
                DB::table('votes')->where([
                    ['user_id', "=", $request['userId']],
                    ['questions_id', "=", $request['questionsId']]
                ])->update(['vote_type' => $voteType]);
            }
            $result = $questions->votes_up - $questions->vote_down;
            $up = $questions->votes_up;
            $down = $questions->votes_down;
            return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }

    }
}
