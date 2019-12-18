@extends('layouts.app')

@section('content')
<br>
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
        Fuga, voluptate porro quibusdam eos tenetur quod sed commodi deserunt cupiditate placeat?</p>

        @if (!Auth::guest())
            {{-- if the user is logged in dont show thw login & Register button --}}
        @else
            {{-- Show the login button --}}
            <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
            <a class="btn btn-success btn-lg" href="/register" role="button">Register </a>
        @endif

    </div>

@endsection
   