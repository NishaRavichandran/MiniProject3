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
                                @forelse($questions as $question)
                                    <div class="col-sm-4 d-flex align-items-stretch">
                                        <div class="card mb-3 ">
                                            <div class="card-header" style="background-color: #1d2124; color: #e2e6ea">
                                                <small style="color: #fefefe">
                                                    Updated: {{ $question->created_at->diffForHumans() }}
                                                    Answers: {{ $question->answers()->count() }}<br>
                                                    @if (\App\Profile::find ($question->user_id))
                                                        Created By: {{ \App\Profile::find ($question->user_id)->fname }}
                                                    @else
                                                        Created By: {{ \App\User::find($question->user_id)->email }}
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{$question->body}}</p>
                                            </div>
                                            <div class="card-footer">
                                                <p class="card-text">
                                                @if (Auth::user())
                                                    @if(Auth::user() != $question->user)
                                                        <div class="votes-area" data-postid="{{ $question->id }}" data-userid="{{ Auth::user()->id }}">
                                                            <span class="vote" data-votetype="up">{{ $question->votes_up }}</span>

{{--                                                            <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.vote', ['id' => $question->id]) }}">--}}
{{--                                                                {{ $question->votes_up }}--}}
{{--                                                            </a>--}}
{{--                                                            <span>{{ $question->result }}</span>--}}
{{--                                                            <span class="vote" data-votetype="down">{{ $question->votes_down }}</span>--}}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="votes-area">
{{--                                                        <span onclick="alert('Only registered users can vote');">{{ $question->votes_up }}</span>--}}
{{--                                                        <span onclick="alert('Only registered users can vote');">{{ $question->result }}</span>--}}
{{--                                                        <span onclick="alert('Only registered users can vote');">{{ $question->votes_down }}</span>--}}
                                                    </div>
                                                @endif

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
                                {{ $questions->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            var token = "{{ Session::token() }}";
            {{--var url = "{{ route('vote') }}";--}}
        </script>
@endsection