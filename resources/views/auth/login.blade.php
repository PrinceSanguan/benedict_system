@extends('layouts.app')

@section('content')
<div class="login-box" style="width: 40% !important">
    <div class="card login-div">
        <div class="card-header row col-lg-12 text-center">
            <div class="col d-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/images/logo.png') }}" width="60px" alt="Logo" class="me-2">
                <h3 class="mb-0">Login Page</h3>
            </div>
        </div>
        <div class="card-body">
            <form {{ route('login') }}" method="POST" class="pt-3" id="loginForm" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Email Address" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" id="loginButton" class="btn btn-block btn-primary font-weight-medium auth-form-btn">LOG IN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.script')
@include('custom_js.login_js')
@endsection
