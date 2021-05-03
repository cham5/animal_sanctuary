@extends('layouts.master')

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
