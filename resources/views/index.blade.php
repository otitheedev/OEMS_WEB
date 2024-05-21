<!-- resources/views/home.blade.php -->
@extends('layouts.main_layout')
@section('title', 'Home')
@section('content')


<style>
a {text-decoration: none;}

.login-page {
    width: 100%;
    height: 100vh;
    display: inline-block;
    display: flex;
    align-items: center;
}
.form-right i {font-size: 100px;}
</style>

<div class="login-page bg-light" style="background-image: url('/dist/loginbackground.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-color: #f0f0f0;
            background-attachment: fixed;
            background-clip: border-box;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">


                  <h3 class="mb-2 text-white" style="text-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.5); ">Otithee Employee Login</h3>
                    <div class="bg-white shadow rounded">
                    @if(auth()->check())<div class="col-12 alert-success p-1"> Welcome back {{ auth()->user()->name }}! </div>@endif
                        <div class="row">
                            <div class="col-md-6 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                @if (isset($message))<div class="alert alert-danger">{{ $message }} </div>@endif
                                    <form method="POST" action="{{ route('login') }}" class="row g-4">
                                    @csrf
                                            <div class="col-12">
                                                <label>Username or Phone <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Username" required autocomplete="email" autofocus>@error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>

                                            </div>



                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" required autocomplete="current-password">@error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-check">

                                               <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>



                                                </div>
                                            </div>

                                         <!--    <div class="col-sm-6">
                                                <a href="{{ url('password/reset')}}" class="float-end text-primary">Forgot Password?</a>
                                            </div> -->

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary px-4 float-end mt-4">{{ __('Login') }} </button>
                                            </div>



                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 ps-0 d-none d-md-block">
                         <img class="form-right h-95 w-100 mt-1 text-center img-fluid" src="{{ url('assets/OG.png') }}">
                            </div>
                        </div>
                    </div>

                <div class="row">
                   <div class="col-6 mt-2">
                   @if(auth()->check())  <a href="{{ url('/admin') }}" class="btn-sm btn-primary"> Admin Dasboard </a>
                    <a href="#" class="btn"></a>@endif
                    <!-- <a href="{{ url('/search/employee')}}" class="btn-sm btn-success"> Search Employee </a>  -->
                </div>   
               
                <div class="col-6 mt-2 text-right">
                         <div class="text-right"> <p class="text-secondary text-white" style="text-align:right;">Otithee Staff Login</p> </div>  
                 </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->









@endsection
