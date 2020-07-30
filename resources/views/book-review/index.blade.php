@extends('layouts.common')

@section('content')
<div class="l-wrapper-inner p-books-wrapper">
  <div class="p-books-contents">
    <h2 class="p-books-contents__head">レビューのある本</h2>
    <a href="{{ route('showResult', 'review') }}" class="p-books-contents__more">もっとみる</a>
    <ul class="slick">
      @foreach ($reviewedBooks as $reviewedBook)
      <li>
        <a href="{{ route('detail', $reviewedBook->ISBN) }}">
          <img class="slick__img" alt="" src="{{ $reviewedBook->book->img }}" />
          <p class="slick__title">{{ Str::limit($reviewedBook->book->title, 15) }}</p>
          <p class="slick__review">レビュー件数： {{ $reviewedBook->review_count }}件</p>
          <div class="c-evaluation">
            <p class="c-evaluation__text">評価</p>
            <div class="c-evaluation__star" data-count="{{ $reviewedBook->evaluation_avg }}">
              @for ($i = 0; $i < ceil($reviewedBook->evaluation_avg); $i++)
              <span class="c-evaluation__star-icon js-star-icon is-star-colord">★</span>
              @endfor
              @for ($i = 0; $i < 5 - ceil($reviewedBook->evaluation_avg); $i++)
              <span class="c-evaluation__star-icon js-star-icon">★</span>
              @endfor
            </div>
          </div>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
  <hr class="c-line">
  <div class="p-books-contents">
    <h2 class="p-books-contents__head">プログラミング</h2>
    <a href="{{ route('showResult', '001005005') }}" class="p-books-contents__more">もっとみる</a>
    <ul class="slick program"></ul>
  </div>
  <hr class="c-line">
  <div class="p-books-contents">
    <h2 class="p-books-contents__head">自己啓発</h2>
    <a href="{{ route('showResult', '001006009') }}" class="p-books-contents__more">もっとみる</a>
    <ul class="slick self"></ul>
  </div>
  <hr class="c-line">
  <div class="p-books-contents">
    <h2 class="p-books-contents__head">ビジネスマナー</h2>
    <a href="{{ route('showResult', '001006023') }}" class="p-books-contents__more">もっとみる</a>
    <ul class="slick business"></ul>
  </div>
  <hr class="c-line">
</div>

<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<span id="js-getUrl" data-name="{{ Config::get('app.url') }}/review"></span>
<span id="js-getPath" data-name="{{ Config::get('app.rakuten_api_path') }}"></span>
<span id="js-getToken" data-name="{{ csrf_token() }}"></span>
<span id="js-getId" data-name="{{ Config::get('app.rakuten_api_app_id') }}"></span>
@endsection
