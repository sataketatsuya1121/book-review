@extends('layouts.app')
@section('content')

<div class="p-login-wrapper">
  <div class="p-login-box">
    <img src="{{ asset('img/logo.png') }}">
    <div class="p-login-box__contents">
      <div class="p-login-box__maillogin">
        <p class="p-login-box__head">メールアドレスでログイン</p>
        {{ Form::open(['route' => 'login']) }}
          <div class="p-login-box__form">
            <input id="email" type="email" class="p-login-box__input @error('email') is-invalid @enderror" placeholder="メールアドレス" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err__text is-login">{{ $errors->first('email') }}</span>
            </span>
            @endif
            <input id="password" type="password" class="p-login-box__input @error('password') is-invalid @enderror" placeholder="パスワード" name="password">
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err__text is-login">{{ $errors->first('password') }}</span>
            </span>
            @endif
            <input type="submit" class="c-button p-login-box__btn is-submit" value="ログイン">
          </div>
        {{ Form::close() }}
      </div>
      <hr>
      <div class="p-login-box__accountlogin">
        <p class="p-login-box__head">お持ちのアカウントでログイン</p>
        <div class="p-login-box__sns">
          <a href="{{ route('google') }}" class="c-button p-login-box__btn is-google">Sign in with Google</a>
          <a href="{{ route('github') }}" class="c-button p-login-box__btn is-github">GitHub ログイン</a>
        </div>
        <div class="p-login-box__newaccount">
          <p class="p-login-box__head">アカウントをお持ちでない方はこちら</p>
          <a href="{{ route('register') }}" class="c-button p-login-box__btn is-newaccount">新規登録</a>
        </div>
      </div>
    </div>
  </div>
  <div class="p-login-forgetpass">
    @if (Route::has('password.request'))
    <a class="" href="{{ route('password.request') }}">
      {{ __('パスワードを忘れた方はこちら') }}
    </a>
    @endif
  </div>
</div>
@endsection