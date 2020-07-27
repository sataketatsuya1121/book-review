@extends('layouts.common')

@section('content')

<div class="l-wrapper-inner p-ranking-wrapper">
  <ul class="p-ranking-category">
    <li class="p-ranking-category__item">
      <a class="p-ranking-category__link" data-category="all">
        <span class="p-ranking-category__circle"></span>
        <img alt="" src="../img/icon_balloon.png">
        <span class="p-ranking-category__text">すべて</span>
      </a>
    </li>
    <li class="p-ranking-category__item">
      <a class="p-ranking-category__link" data-category="program">
        <span class="p-ranking-category__circle"></span>
        <img alt="" src="../img/icon_pc.png">
        <span class="p-ranking-category__text">プログラミング</span>
      </a>
    </li>
    <li class="p-ranking-category__item">
      <a class="p-ranking-category__link" data-category="self">
        <span class="p-ranking-category__circle"></span>
        <img alt="" src="../img/icon_book.png">
        <span class="p-ranking-category__text">自己啓発</span>
      </a>
    </li>
    <li class="p-ranking-category__item">
      <a class="p-ranking-category__link" data-category="business">
        <span class="p-ranking-category__circle"></span>
        <img alt="" src="../img/icon_suit.png">
        <span class="p-ranking-category__text">ビジネスマナー</span>
      </a>
    </li>
  </ul>

  <div class="p-ranking-order"></div>

  <div class="p-ranking-book">
    <p class="p-ranking-book__head">以下6位～30位</p>
    <ul class="p-ranking-book__list"></ul>
  </div>
</div>
<script src="{{ asset('js/ranking.js') }}"></script>

<span id="js-getUrl" data-name="{{ Config::get('app.url') }}/review"></span>
<span id="js-getPath" data-name="{{ Config::get('app.rakuten_api_path') }}"></span>
<span id="js-getToken" data-name="{{ csrf_token() }}"></span>
<span id="js-getId" data-name="{{ Config::get('app.rakuten_api_app_id') }}"></span>

@endsection
