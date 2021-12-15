@extends('layouts.website')

@section('content')


  <main class="container">
    <section class="login-container">
      <div class="login-cols">
        <div class="login-logo">
          <img
            src=" {{asset('storage/img/assets/login-img.png')}}"
            alt=""
            srcset=""
            class="login-img"
          />
        </div>
        <div class="login-form">
            <form method="POST" action="{{ Route('login') }}" class="text-left">

                @csrf
           
            <div class="form-group">
              <label for="email"> Email </label>
              <i class="bi bi-at"></i>
              <input
                type="email"
                name="email"
                id="email"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter Email Address"
              />
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

            <div class="form-group">
                <label for="name"> Password </label>
                <i class="bi bi-person"></i>
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="form-control @error('password') is-invalid @enderror"
                  placeholder="Enter Full Name"
                />
              </div>

              @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
            <div class="form-group">
              <input
                type="submit"
                class="btn btn-lg btn-block login-btn"
                value="Sign In"
              />
            </div>
            <div class="user-actions">
              <div class="forgot-password">
                <span> Forgot your password? </span>
              </div>
              <div class="sign-up">
                <span> Not registered yet? <a style="text-decoration: none" href="{{Route('website.register')}}">Sign up here.</a> </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  @endsection