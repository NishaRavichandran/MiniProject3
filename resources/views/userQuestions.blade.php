@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Questions
                        <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.create') }}">
{{--                            <a class="btn btn-primary float-right" href="#">--}}
                            Create a Question
                        </a>

                        <div class="card-body">

                            <div class="card-deck">
                                @forelse($userQuestions as $question)
                                    <div class="col-sm-4 d-flex align-items-stretch">
                                        <div class="card mb-3 ">
                                            <div class="card-header" style="background-color: #1d2124; color: #e2e6ea">
                                                <small style="color: #fefefe">
                                                    Updated: {{ $question->created_at->diffForHumans() }}
                                                    Answers: {{ $question->answers()->count() }}

                                                </small>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{$question->body}}</p>
                                            </div>
                                            <div class="card-footer">
                                                <p class="card-text">

                                                    <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.show', ['id' => $question->id]) }}">
                                                        View
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <a class="btn btn-primary" style="background-color: mediumblue" href="{{ route('question.create') }}">
                                    There are no questions to view, you can  create a question.
                                    </a>
                                @endforelse


                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                {{ $userQuestions->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection