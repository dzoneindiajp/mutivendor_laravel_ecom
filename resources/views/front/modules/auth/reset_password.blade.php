@extends('front.layouts.app',['page' => 'login'])
@push('styles')
<link href="{{ asset('assets/front/css/login.css') }}" rel="stylesheet">
@endpush
@section('content') 
<form action="{{route('front-user.resetPasswordSave')}}" method="post" autocomplete="off">  
@csrf 
<div class="login-section">
        <div class="container">
            <div class="login-box">
                
                <div class="white-box">
                    <div class="text-center w-100 mb-5">
                        <img src="{{asset('assets/front/img/logo/logo-black.png')}}" width="250" />
                    </div>
                    <!--<h2 class="mb-4">Reset password</h2>-->
                    <div class="form-group">
                        <label>Create password</label>
                        <input type="password" name="new_password" class="form-control login @error('new_password') is-invalid @enderror" placeholder="Create a new password" />
                        @if ($errors->has('new_password'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('new_password') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control login @error('new_password_confirmation') is-invalid @enderror" placeholder="Re-enter your Password" />
                        @if ($errors->has('new_password_confirmation'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('new_password_confirmation') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                    <button type="submit" href="success-password.html" class="login-button">
                            Change password <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                            </svg>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection