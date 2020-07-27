@extends('layouts.common')

@section('content')

<div class="l-wrapper-inner p-newbook-wrapper">
  <h1 class="c-section__title p-newbook__head">新刊</h1>
  <ul class="p-newbook__list"></ul>
</div>
<script src="{{ asset('js/newBook.js') }}"></script>

<span id="js-getUrl" data-name="{{ Config::get('app.url') }}/review"></span>
<span id="js-getPath" data-name="{{ Config::get('app.rakuten_api_path') }}"></span>
<span id="js-getToken" data-name="{{ csrf_token() }}"></span>
<span id="js-getId" data-name="{{ Config::get('app.rakuten_api_app_id') }}"></span>
@endsection
