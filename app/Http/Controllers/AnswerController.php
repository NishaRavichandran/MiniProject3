<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Answer;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
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
    public function create($question)
    {
        $answer = new Answer;
        $edit = FALSE;
        return view('answerForm', ['answer' => $answer,'edit' => $edit, 'question' =>$question  ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $question)
    {

        $input = $request->validate([
            'body' => 'required|min:5',
        ], [

            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',

        ]);
        $input = request()->all();
        $question = Question::find($question);
        $Answer = new Answer($input);
        $Answer->user()->associate(Auth::user());
        $Answer->question()->associate($question);
        $Answer->save();

        return redirect()->route('question.show',['question_id' => $question->id])->with('message', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question,  $answer)
    {
        $answer = Answer::find($answer);

        return view('answer')->with(['answer' => $answer, 'question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($question,  $answer)
    {
        $answer = Answer::find($answer);
        $edit = TRUE;
        return view('answerForm', ['answer' => $answer, 'edit' => $edit, 'question'=>$question ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $question, $answer)
    {
        $input = $request->validate([
            'body' => 'required|min:5',
        ], [

            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',

        ]);

        $answer = Answer::find($answer);
        $answer->body = $request->body;
        $answer->save();

        return redirect()->route('answers.show',['question_id' => $question, 'answer_id' => $answer])->with('message', 'Your Message has been Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($question, $answer)
    {
        $answer = Answer::find($answer);

        $answer->delete();
        return redirect()->route('question.show',['question_id' => $question])->with('message', 'Your Message has been Deleted');

    }
    public function vote(Request $request)
    {
        error_log($request);
        $userId = $request['userId'];
       // $questionId = $request['postId'];
        $answerId = $request['answerId'];
        $voteType = $request['voteType'];
        $token = $request['_token'];
        //error_log("******************************inside vote after step 1"+$request);
        // query below returns vote_type('up' or 'down') or null
        $vote = \DB::table('answervotes')->where([
            ['user_id', "=", $userId],
//            ['question_id', "=", $questionId],
            ['answer_id', "=", $answerId]
        ])->value('vote_type');
//        $vote = DB::table('votes')->where([
//            'user_id' => $userId,
//            'question_id' => $questionId
//        ]);
        //->value('vote_type');
        //   error_log($vote);
        // if user didn't vote
        if (!$vote) {
            error_log("**********Inside method*******");
            \DB::table('answervotes')->insert([
//                'question_id' => $questionId,
                'user_id' => $userId,
                'answer_id' => $answerId,
                'vote_type' => $voteType
            ]);
            $answer = Answer::find($answerId);
            if ($voteType == "up") {
                $answerVotesUp = $answer->votes_up;
                $answerVotesUp = $answerVotesUp + 1;
                $answer->votes_up = $answerVotesUp;
                $answerVotesDown = $answer->votes_down;
                $answerresult = $answerVotesUp - $answerVotesDown;
                $answer->answer_result = $answerresult;
                $answer->update();
            } else if ($voteType == "down"){
                $answerVotesDown = $answer->votes_down;
                $answerVotesDown = $answerVotesDown + 1;
                $answer->votes_down = $answerVotesDown;
                $answerVotesUp = $answer->votes_up;
                $answerresult = $answerVotesUp - $answerVotesDown;
                $answer-> answer_result = $answerresult;
                $answer->update();
            }
//            \DB::table('questions')->where([
//                ['questions_id', "=", $questionId]
//            ])->update(['result' => $question->result]);
            //$result = $question->votes_up - $question->votes_down;
            $up = $answer->votes_up;
            $down = $answer->votes_down;
            return response()->json(['result' => $answerresult, 'up' => $up, 'down' => $down], 200);
        }else if ($vote == $voteType) {
            return response()->json(['warning' => 'You can not vote twice(up or down) for same question'], 200);
        }
        else {
            error_log("**********Inside else*******");
            $answer = Answer::find($answerId);
            error_log($answer);
            if ($voteType == 'up') {
                // update votes field in posts Table
                $answerVotesDown = $answer->votes_down;
                $answerVotesDown = $answerVotesDown - 1;
                $answer->votes_down = $answerVotesDown;
                $answerVotesUp = $answer->votes_up;
                $answerVotesUp = $answerVotesUp + 1;
                $answer->votes_up = $answerVotesUp;
                $result = $answerVotesUp - $answerVotesDown;
                $answer->answer_result = $result;
                $answer->update();
                \DB::table('answervotes')->where([
                    ['user_id', "=", $userId],
//                    ['question_id', "=", $questionId],
                    ['answer_id', "=", $answerId]
                ])->update(['vote_type' => $voteType]);
            } else {
                // update votes field in posts Table
                $answerVotesUp = $answer->votes_up;
                $answerVotesUp = $answerVotesUp - 1;
                $answer->votes_up = $answerVotesUp;
                $answerVotesDown = $answer->votes_down;
                $answerVotesDown = $answerVotesDown + 1;
                $answer->votes_down = $answerVotesDown;
                error_log($answer->votes_up);
                error_log($answer->votes_down);
                $result = $answerVotesUp - $answerVotesDown;
                error_log($result);
                $answer->answer_result = $result;
                $answer->update();
                \DB::table('answervotes')->where([
                    ['user_id', "=", $userId],
//                    ['question_id', "=", $questionId],
                    ['answer_id', "=", $answerId]
                ])->update(['vote_type' => $voteType]);
            }
            //$result = $question->votes_up - $question->vote_down;
            $up = $answer->votes_up;
            $down = $answer->votes_down;
            return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }
    }
}
