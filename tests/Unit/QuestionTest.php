<?php

namespace Tests\Unit;

use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSave()
    {
        $user = $user = factory(\App\User::class)->make();
        $user->save();
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user);
        $this->assertTrue($question->save());
    }
    public function testSortBy()
    {
        $question = Question::orderBy('created_at','desc')->get();
        $questionCount= count($question);
            $this->assertGreaterThan(0, $questionCount);
    }

    public function testOrderBy()
    {
        $question = Question::orderBy('result','desc')->get();
        $questionCount= count($question);
        $this->assertGreaterThan(0, $questionCount);
    }

}
