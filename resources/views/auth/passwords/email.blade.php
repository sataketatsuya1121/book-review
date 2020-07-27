@extends('layouts.app')

@section('content')
    <div class="p-reset-request">
      <div class="l-wrapper">
        <div class="p-reset-request-content">
            <div class="">
                <p class="c-section-title p-reset-request-content-title">パスワードのリセット</p>
                <div class="p-reset-request-content-desc">ご登録されているメールアドレス宛に、パスワードの再設定用URLをお送りします。<br> 下記にメールアドレスを記載して、再登録用メールのURLから、再度アクセスを行ってください。</div>

                <div class="p-reset-request-form">
                    <form method="POST" action="{{ url('/password/email') }}">
                    @csrf
                        <div class="p-reset-request-form-lists">
                            <p class="c-form-input-title">メールアドレス</p>
                            <div class="p-reset-request-form-input">
                                <input id="email" type="email" class="c-form-input-text form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <span class="c-err-text is-login">{{ $message }}</span>
                                </span>
                                @enderror
                                @error('error')
                                <span class="invalid-feedback" role="alert">
                                    <span class="c-err-text is-login">{{ session('error') }}</span>
                                </span>
                                @enderror
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="c-button p-reset-request-form-submit">
                            送信する
                        </button>
                    </form>

                    <!-- <form method="POST" action="{{ url('/password/email') }}">
                        @csrf

                        <div class="p-reset-request-content-form">
                            <label for="email" class="c-form-input-title">メールアドレス</label>

                            <div class="">
                                <input id="email" type="email" class="c-form-input-text p-reset-request-content-form-input" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if(session('error') !== null)
                                    {{ session('error') }}
                                @endif

                                @if(session('success'))
                                    {{ session('success') }}
                                @endif
                            </div>
                        </div>

                        <div class="">
                            <div class="">
                                <button type="submit" class="c-button">
                                    送信する
                                </button>
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
