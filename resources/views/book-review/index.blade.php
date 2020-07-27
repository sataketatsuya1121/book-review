@extends('layouts.common')

@section('content')
<div class="l-wrapper-inner p-books-wrapper">
  <div class="p-books-contents">
    <h2 class="p-books-contents-head">レビューのある本</h2>
    <a href="{{ route('showResult') }}" class="p-books-contents-more">もっとみる</a>
    <ul class="slick">
      @foreach ($reviewedBooks as $index => $reviewedBook)
      <li>
        <a href="{{ route('detail', $reviewedBook->first()->book->ISBN) }}">
        <img class="slick-img" alt="" src="{{ $reviewedBook->first()->book->img }}" />
          <p class="slick-title">{{ Str::limit($reviewedBook->first()->book->title, 15) }}</p>
          <p class="slick-review">レビュー件数： {{ $reviewedBook->count() }}件</p>
          <div class="c-evaluation">
            <p class="c-evaluation-txt">評価</p>
            <div class="c-evaluation-star" data-count="{{ $evlAvgrages[$index] }}">
              @for ($i = 0; $i < $evlAvgrages[$index]; $i++)
              <span class="c-evaluation-star-icon js-star-icon is-star-colord">★</span>
              @endfor
              @for ($i = 0; $i < 5 - $evlAvgrages[$index]; $i++)
              <span class="c-evaluation-star-icon js-star-icon">★</span>
              @endfor
            </div>
          </div>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
  <hr class="p-books-hr">
  <div class="p-books-contents">
    <h2 class="p-books-contents-head">プログラミング</h2>
    <a href="{{ route('showResult') }}?search_query=プログラミング" class="p-books-contents-more">もっとみる</a>
    <ul class="slick program"></ul>
  </div>
  <hr class="p-books-hr">
  <div class="p-books-contents">
    <h2 class="p-books-contents-head">自己啓発</h2>
    <a href="{{ route('showResult') }}?search_query=自己啓発" class="p-books-contents-more">もっとみる</a>
    <ul class="slick self"></ul>
  </div>
  <hr class="p-books-hr">
  <div class="p-books-contents">
    <h2 class="p-books-contents-head">ビジネスマナー</h2>
    <a href="{{ route('showResult') }}?search_query=ビジネスマナー" class="p-books-contents-more">もっとみる</a>
    <ul class="slick business"></ul>
  </div>
  <hr class="p-books-hr">
</div>
<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>

<span id="js-getUrl" data-name="{{ Config::get('app.url') }}/review"></span>
<span id="js-getPath" data-name="{{ Config::get('app.rakuten_api_path') }}"></span>
<span id="js-getToken" data-name="{{ csrf_token() }}"></span>
<span id="js-getId" data-name="{{ Config::get('app.rakuten_api_app_id') }}"></span>
@endsection
