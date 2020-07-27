@extends('layouts.common')

@section('content')

{{-- ここに読みたい本リストのhtmlを記述してね --}}

<div class="l-wrapper-inner p-books-wrapper">
  <div class="p-books-contents">
    <h2 class="p-books-contents-head"></h2>
    <ul class="p-result-sort">
      <li><button class="p-result-sort-release">新刊</button></li>
      <li><button class="p-result-sort-sales">売り上げ</button></li>
    </ul>
    <ul class="p-result p-result-reviewedBooks p-result-disactive">
      @foreach ($reviewedBooks as $reviewedBook)
      <li>
        <a href="{{ route('detail', $reviewedBook->book->ISBN) }}" class="p-result-list">
        <img class="p-result-list-image" alt="" src="{{ $reviewedBook->book->img }}" />
          <p class="p-result-list-title">{{ Str::limit($reviewedBook->book->title, 15) }}</p>
          <p class="p-result-list-review">レビュー件数： {{ count($arrangeLatestIsbn->toArray()[$reviewedBook->ISBN]) }}件</p>
          <div class="c-evaluation">
            <p class="c-evaluation-txt">評価</p>
            <div class="c-evaluation-star" data-count="{{ $evlAvgrages[$reviewedBook->ISBN] }}">
              @for ($i = 0; $i < $evlAvgrages[$reviewedBook->ISBN]; $i++)
              <span class="c-evaluation-star-icon js-star-icon is-star-colord">★</span>
              @endfor
              @for ($i = 0; $i < 5 - $evlAvgrages[$reviewedBook->ISBN]; $i++)
              <span class="c-evaluation-star-icon js-star-icon">★</span>
              @endfor
            </div>
          </div>
        </a>
      </li>
      @endforeach
    </ul>
    <ul class="p-result p-result-program"></ul>
    <ul class="p-result p-result-self"></ul>
    <ul class="p-result p-result-business"></ul>
    <ul class="p-result p-result-keyword"></ul>
    <div class="p-result-disactive">{{ $reviewedBooks->links() }}</div>
    <nav class="p-result-paginate">
      <ul class="pagination p-result-paginate-list"></ul>
    </nav>
  </div>
  <hr class="p-books-hr">
</div>

<script src="{{ asset('js/result.js') }}"></script>
<span id="js-getPath" data-name="{{ Config::get('app.rakuten_api_path') }}"></span>
<span id="js-search-query" data-name="{{ $queryParams['search_query'] ?? null }}"></span>
<span id="js-condition" data-name="{{ $queryParams['condition'] ?? null }}"></span>
<span id="js-keyword" data-name="{{ $queryParams['keyword'] ?? null }}"></span>
<span id="js-page" data-name="{{ $queryParams['page'] ?? null }}"></span>
<span id="js-getId" data-name="{{ Config::get('app.rakuten_api_app_id') }}"></span>
<span id="js-getBaseUrl" data-name="{{ Config::get('app.url') }}"></span>
@endsection
