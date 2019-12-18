@extends('layouts.app')

@section('content')

<a class="btn btn-dark" href="/posts">Go Back</a>
    <h1>{{$post->title}}</h1>
     <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
     <br>
     <br>
    <div>
        {{-- {{$post->body}} --}}
        {{-- Pass HTML with below line --}}
       <p> {!!$post->body!!}</p>
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by <b>{{$post->user->name}}</b></small>
    <hr>
    {{-- IF USER IS NOT A GUEST SHOW EDIT & DELETE BUTTON --}}
    @if (!Auth::guest())
        {{-- SHOW THE EDIT & DELETE BUTTON IF THE USER ID AND POST ID MATCHES --}}
        @if (Auth::user()->id == $post->user_id)

        <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>

        {!!Form::open(['action'=>['PostsController@destroy',$post->id],'method'=>'POST','class'=>'float-right'])!!}
            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
        {!!Form::close()!!}
        @endif
    @endif
@endsection