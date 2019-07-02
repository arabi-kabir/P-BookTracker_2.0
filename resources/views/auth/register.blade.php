@extends('layouts.auth_layout.master')

@section('content')

    <div class="text-center mb-4">
        <h4 class="text-uppercase mt-0">Sign Up</h4>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" placeholder="Enter your name">

            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email Address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Enter your email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder="Enter password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" placeholder="Enter confirm password">
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>

    </form>

@endsection

@section('bottom_content')
    <div class="row mt-3">
        <div class="col-12 text-center">

            {{--<p> <a href="pages-recoverpw.html" class="text-muted ml-1"><i class="fa fa-lock mr-1"></i>Forgot your password?</a></p>--}}

            {{--@if (Route::has('password.request'))--}}
                {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                    {{--{{ __('Forgot Your Password?') }}--}}
                {{--</a>--}}
            {{--@endif--}}


            <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-dark ml-1"><b>Sign In</b></a></p>
        </div> <!-- end col -->
    </div>
@endsection