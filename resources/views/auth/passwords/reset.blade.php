
@extends('layouts.app')

@section('content')
    <div class="p-reset-password">
      <div class="l-wrapper">
        <div class="p-reset-password-content">
            <div class="">
                <p class="c-section__title p-reset-password-content-title">パスワードのリセット</p>
                <div class="p-reset-password-content-desc">ご登録のメールアドレスと、新しいメールアドレスを入力してください。<br>確認のため、新しいパスワードは２箇所に入力をしてください。</div>
                <div class="p-reset-password-form">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="p-reset-password-form-lists">
                            <p class="c-form__title">メールアドレス</p>
                            <div class="p-reset-password-form-input">
                                <input id="email" type="email" class="c-form__text @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="入力してください" autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                  <span class="c-err__text is-login">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="p-reset-password-form-lists">
                            <p class="c-form__title">新しいパスワード</p>
                            <div class="p-reset-password-form-input">
                                <input id="password" type="password" class="c-form__text @error('password') is-invalid @enderror" name="password" placeholder="入力してください" autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                  <span class="c-err__text is-login">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="p-reset-password-form-lists">
                            <p class="c-form__title">新しいパスワード(確認)</p>
                            <div class="p-reset-password-form-input">
                                <input id="password-confirm" type="password" class="c-form__text" name="password_confirmation" placeholder="確認のため再度入力してください" autocomplete="new-password">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                  <span class="c-err__text is-login">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="c-button p-reset-password-form-submit">
                            送信する
                        </button>
                    </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
