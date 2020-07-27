@extends('layouts.app')
@section('content')

<div class="l-wrapper p-register-wrapper">
  <div class="p-register-box">
    <!-- 新規登録画面 -->
    <a href="{{ route('login') }}" class="p-register-box__backbtn">
      <img src="../img/left-arrow.png">
    </a>
    <h1 class="p-register-box__head">新規登録</h1>
    <div class="p-register-formarea">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">名前</p>
          <div class="p-register-formarea__input">
            <input id="name" type="text" class="c-form-input-text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('name') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">メールアドレス</p>
          <div class="p-register-formarea__input">
            <input id="email" type="email" class="c-form-input-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('email') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">パスワード</p>
          <div class="p-register-formarea__input">
            <input id="password" type="password" class="c-form-input-text @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('password') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">パスワード再入力</p>
          <div class="p-register-formarea__input">
            <input id="password-confirm" type="password" class="c-form-input-text" name="password_confirmation" autocomplete="new-password">
            @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('password_confirmation') }}</span>
            </span>
            @endif
          </div>
        </div>
        <input type="submit" class="p-register-formarea__submit c-button is-orange" value="登録する">
      </form>
    </div>


    <!-- マイページ登録 -->  
    <!-- 新規登録画面の「登録する」ボタンが押されたらマイページ登録画面に遷移するようにしてほしいです！！
    マイページ登録画面の「登録する」ボタンが押されて初めてユーザー登録完了となります＊ -->
    <!-- <h1 class="p-register-box__head">マイページ登録</h1>
    <div class="p-register-formarea">
      <div class="p-register-formarea__item">
        <p class="c-form-input-title p-register-formarea__text">職種</p>
        <div class="p-register-formarea__input">
          <select name="job" class="c-form-input-text">
            <option value="">選択してください</option>
            <option value="フロントエンドエンジニア">フロントエンドエンジニア</option>
            <option value="バックエンドエンジニア">バックエンドエンジニア</option>
            <option value="営業">営業</option>
            <option value="人事">人事</option>
          </select>
        </div>
        <span class="c-err-text is-login"></span>
      </div>
      <div class="p-register-formarea__item">
        <p class="c-form-input-title p-register-formarea__text">入社年月</p>
        <div class="p-register-formarea__input">
          <select id="year" class="c-form-input-text p-register-formarea__input is-short"><option value="0">----</option></select>
          <span class="p-register-formarea__text is-small">年</span>
          <select id="month" class="c-form-input-text p-register-formarea__input is-short"><option value="0">--</option></select>
          <span class="p-register-formarea__text is-small">日</span>
        </div>
      </div>
      <div class="p-register-formarea__item">
        <p class="c-form-input-title p-register-formarea__text">知見のある言語</p>
        <div class="p-register-formarea__input">
          <input type="text" class="c-form-input-text">
        </div>
      </div>
    </div>
    <input type="submit" class="p-register-formarea__submit--mypagebtn c-button" value="登録する"> -->
  </div>
</div>
@endsection
