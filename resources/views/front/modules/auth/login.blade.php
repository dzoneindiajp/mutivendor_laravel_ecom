@extends('front.layouts.app',['page' => 'login'])
@push('styles')
<link href="{{ asset('assets/front/css/login.css') }}" rel="stylesheet">
@endpush
@section('content')  
<form action="{{route('front-user.postLogin')}}" method="post" autocomplete="off">   
@csrf 
<div class="login-section">
        <div class="container">
            <div class="login-box">                
                <div class="white-box">
                    <div class="text-center w-100 mb-4">
                        <img src="{{asset('assets/front/img/logo/logo-black.png')}}" width="250" />
                    </div>
                    <!--<h2 class="mb-4">LOGIN</h2>-->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control login @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{old('email')}}" />
                        @if ($errors->has('email'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control login @error('password') is-invalid @enderror" placeholder="Enter your password" />
                        @if ($errors->has('password'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <p>&nbsp;<span style="float:right;"><a href="{{route('front-user.forgetPassword')}}" class="forgot-password">Forgot password?</a></span></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" href="index.html" class="login-button">
                            Login <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <div class=" text-center form-group">
                        <p>Don’t have an account? <a href="{{route('front-user.signup')}}" class="forgot-password">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection