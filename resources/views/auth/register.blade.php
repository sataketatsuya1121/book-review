@extends('layouts.app')
@section('content')

<div class="l-wrapper p-register-wrapper">
  <div class="p-register-box">
    <a href="{{ route('login') }}" class="p-register-box__backbtn">
      <img src="../img/left-arrow.png">
    </a>
    <h1 class="p-register-box__head">新規登録</h1>
    <div class="p-register-formarea">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="p-register-formarea__item">
          <p class="c-form__title p-register-formarea__text">名前</p>
          <div class="p-register-formarea__input">
            <input id="name" type="text" class="c-form__text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err__text is-login">{{ $errors->first('name') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form__title p-register-formarea__text">メールアドレス</p>
          <div class="p-register-formarea__input">
            <input id="email" type="email" class="c-form__text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err__text is-login">{{ $errors->first('email') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form__title p-register-formarea__text">パスワード</p>
          <div class="p-register-formarea__input">
            <input id="password" type="password" class="c-form__text @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err__text is-login">{{ $errors->first('password') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form__title p-register-formarea__text">パスワード再入力</p>
          <div class="p-register-formarea__input">
            <input id="password-confirm" type="password" class="c-form__text" name="password_confirmation" autocomplete="new-password">
            @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err__text is-login">{{ $errors->first('password_confirmation') }}</span>
            </span>
            @endif
          </div>
        </div>
        <input type="submit" class="p-register-formarea__submit c-button is-orange" value="登録する">
      </form>
    </div>
  </div>
</div>
@endsection
