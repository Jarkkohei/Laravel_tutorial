@extends('layouts.app');

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
    
    <div>   
        <!-- two exclamation marks instead of curlybraces because ckeditor html parsing -->
        {!!$post->body!!}
    </div>

    <hr>

    <small>Written on {{$post->created_at}}</small>
@endsection