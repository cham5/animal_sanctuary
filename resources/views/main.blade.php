@extends('layouts.master')

<!--    Landing page that users will see when opening the website link. 
        Contains a title and a prompt for users to either login/register or
        go to the home page if they're already logged in. -->
        
@section('content')
<div class="content">
    <div class="title">
        Aston Animal Sanctuary
    </div>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="links">
                @auth
                    <p>Click home to continue.</p>
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <p>Please log in or register to continue.</p>
                    <a href="{{ route('login') }}">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>

@endsection
