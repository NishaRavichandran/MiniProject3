<?php
namespace App\Http\Controllers;
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
        return redirect()->route('home')->with('message', 'Your Question has been recorded!');
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
        error_log("******************************inside update");
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
        //error_log($request['userId']);
        $userId = $request['userId'];
        $questionId = $request['postId'];
        $voteType = $request['voteType'];
        $token = $request['_token'];
        //error_log("******************************inside vote after step 1"+$request);
        // query below returns vote_type('up' or 'down') or null
        $vote = \DB::table('votes')->where([
            ['user_id', "=", $userId],
            ['questions_id', "=", $questionId]
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
            \DB::table('votes')->insert([
                'questions_id' => $questionId,
                'user_id' => $userId,
                'vote_type' => $voteType
            ]);
            $question = Question::find($questionId);
            if ($voteType == "up") {
                $questionVotesUp = $question->votes_up;
                $questionVotesUp = $questionVotesUp + 1;
                $question->votes_up = $questionVotesUp;
                $questionVotesDown = $question->votes_down;
                $result = $questionVotesUp - $questionVotesDown;
                $question->result = $result;
                $question->update();
            } else if ($voteType == "down"){
                $questionVotesDown = $question->votes_down;
                $questionVotesDown = $questionVotesDown + 1;
                $question->votes_down = $questionVotesDown;
                $questionVotesUp = $question->votes_up;
                $result = $questionVotesUp - $questionVotesDown;
                $question->result = $result;
                $question->update();
            }
//            \DB::table('questions')->where([
//                ['questions_id', "=", $questionId]
//            ])->update(['result' => $question->result]);
            //$result = $question->votes_up - $question->votes_down;
            $up = $question->votes_up;
            $down = $question->votes_down;
            return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }else if ($vote == $voteType) {
            return response()->json(['warning' => 'You can not vote twice(up or down) for same question'], 200);
        }
        else {
            error_log("**********Inside else*******");
            $question = Question::find($questionId);
            error_log($question);
            if ($voteType == 'up') {
                // update votes field in posts Table
                $questionVotesDown = $question->votes_down;
                $questionVotesDown = $questionVotesDown - 1;
                $question->votes_down = $questionVotesDown;
                $questionVotesUp = $question->votes_up;
                $questionVotesUp = $questionVotesUp + 1;
                $question->votes_up = $questionVotesUp;
                $result = $questionVotesUp - $questionVotesDown;
                $question->result = $result;
                $question->update();
                \DB::table('votes')->where([
                    ['user_id', "=", $userId],
                    ['questions_id', "=", $questionId]
                ])->update(['vote_type' => $voteType]);
            } else {
                // update votes field in posts Table
                $questionVotesUp = $question->votes_up;
                $questionVotesUp = $questionVotesUp - 1;
                $question->votes_up = $questionVotesUp;
                $questionVotesDown = $question->votes_down;
                $questionVotesDown = $questionVotesDown + 1;
                $question->votes_down = $questionVotesDown;
                error_log($question->votes_up);
                error_log($question->votes_down);
                $result = $questionVotesUp - $questionVotesDown;
                error_log($result);
                $question->result = $result;
                $question->update();
                \DB::table('votes')->where([
                    ['user_id', "=", $userId],
                    ['questions_id', "=", $questionId]
                ])->update(['vote_type' => $voteType]);
            }
            //$result = $question->votes_up - $question->vote_down;
            $up = $question->votes_up;
            $down = $question->votes_down;
            return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }
    }
}
