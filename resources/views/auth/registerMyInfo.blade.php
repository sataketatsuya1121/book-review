@extends('layouts.app')
@section('content')

<div class="l-wrapper p-register-wrapper">
  <div class="p-register-box">
    <h1 class="p-register-box__head">マイページ登録</h1>
    <div class="p-register-formarea">
      {{ Form::open(['route' => 'createMyInfo']) }}
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">職種</p>
          <div class="p-register-formarea__input @error('dept_id') is-invalid @enderror">
            {{ Form::select('dept_id', $departments, null, ['class' => 'c-form-input-text', 'placeholder' => '選択して下さい']) }}
            @if ($errors->has('dept_id'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('dept_id') }}</span>
            </span>
            @endif
          </div>
          <span class="c-err-text is-login"></span>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">入社年月</p>
          <div class="p-register-formarea__input @error('joined_company_date') is-invalid @enderror">
            {{ Form::input('month', 'joined_company_date', null, ['class' => 'c-form-input-text']) }}
            @if ($errors->has('joined_company_date'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('joined_company_date') }}</span>
            </span>
            @endif
          </div>
        </div>
        <div class="p-register-formarea__item">
          <p class="c-form-input-title p-register-formarea__text">知見のある言語</p>
          <div class="p-register-formarea__input @error('lang') is-invalid @enderror">
            {{ Form::text('lang', null, ['class' => 'c-form-input-text']) }}
            @if ($errors->has('lang'))
            <span class="invalid-feedback" role="alert">
              <span class="c-err-text is-login">{{ $errors->first('lang') }}</span>
            </span>
            @endif
          </div>
        </div>
        {{ Form::submit('登録する', ['class' => 'p-register-formarea__submit--mypagebtn c-button']) }}
      {{ Form::close() }}
    </div>
  </div>
</div>

@endsection
