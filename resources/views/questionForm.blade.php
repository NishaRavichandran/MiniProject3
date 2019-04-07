@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #1d2124; color: #f8fafc; font-size: large">Create Question</div>
                    <div class="card-body">
                        @if($edit === FALSE)
                        {!! Form::model($question, ['action' => 'QuestionController@store']) !!}
                        @else()
                            {!! Form::model($question, ['route' => ['question.update', $question->id], 'method' => 'patch']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('body', 'Body') !!}
                            {!! Form::text('body', $question->body, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <button class="btn btn-success float-right" value="submit" type="submit" id="submit" style="background-color: forestgreen">Save
                        </button>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
