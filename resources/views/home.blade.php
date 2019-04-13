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


                                                            <img class="voter" data-votetype="up" src="https://www.pinclipart.com/picdir/middle/77-779781_thumbs-up-svg-png-icon-free-download-423440.png" width="30" height="30">
                                                            <span >{{ $question->votes_up }}</span><br>

{{--                                                            <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.vote', ['id' => $question->id]) }}">--}}
{{--                                                                {{ $question->votes_up }}--}}
{{--                                                            </a>--}}
                                                            <span>{{ $question->result }}</span><br>
                                                            <img class="voter" data-votetype="down" src="https://www.pinclipart.com/picdir/middle/17-174878_thumbs-down-comments-thumbs-down-vector-png-clipart.png" width="30" height="30">
                                                            <span>{{ $question->votes_down }}</span>
{{--                                                            <span class="voter" data-votetype="down">{{ $question->votes_down }}</span>--}}
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
    </div>
        <script type="text/javascript">
            window.onload = function() {
                var token = "{{ Session::token() }}";
                var url = "{{ route('question.vote') }}";
                var voteSpans = document.getElementsByClassName("voter");
                //var voteSpans = document.querySelectorAll("voter");

               // console.log(voteSpans.length);
                for (var i = 0; i < voteSpans.length; i++) {
                    //   console.log("on click");
                    //voteSpans[i].addEventListener('click', vote, true);
                    voteSpans[i].addEventListener('click', vote, false);
                    // console.log(voteSpans[i]);
                }

                function vote() {
                    console.log("something");
                    var voteType = this.dataset.votetype;
                    var parentDiv = this.parentNode;
                    var postId = parentDiv.dataset.postid;
                    var userId = parentDiv.dataset.userid;
                    var spanClicked = this;


                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var obj = JSON.parse(xhr.responseText);
                            console.log(obj);
                            if ("warning" in obj) {
                                var pWarning = document.createElement("p");
                                pWarning.textContent = obj.warning;
                                spanClicked.parentNode.appendChild(pWarning);
                                setTimeout(function functionName() {
                                    spanClicked.parentNode.removeChild(pWarning);
                                }, 3000);
                            }
                            else {
                                if (spanClicked.dataset.votetype == "up") {
                                    spanClicked.textContent = obj.up;
                                    spanClicked.nextElementSibling.textContent = obj.result;
                                    spanClicked.nextElementSibling.nextElementSibling.textContent = obj.down;
                                }
                                else if(spanClicked.dataset.votetype == "down") {
                                    spanClicked.textContent = obj.down;
                                    spanClicked.previousElementSibling.textContent = obj.result;
                                    spanClicked.previousElementSibling.previousElementSibling.textContent = obj.up;
                                }
                            }
                        }
                    }

                    xhr.open('POST', url, true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
                    xhr.send("postId=" + postId + "&userId=" + userId + "&voteType=" + voteType + "&_token=" + token);
                }

            };


        </script>
@endsection