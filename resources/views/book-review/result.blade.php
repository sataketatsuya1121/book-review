@extends('layouts.common')

@section('content')

<div class="l-wrapper-inner p-result-wrapper">
  <!-- レビューのある本 -->
  @if (isset($reviewedBooks))
  <div class="p-result-head">
    <h1 class="c-section__title ">レビューのある本</h1>
  </div>
  <ul class="p-result">
    @foreach ($reviewedBooks as $reviewedBook)
    <li>
      <a href="{{ route('detail', $reviewedBook->ISBN) }}" class="p-result__link">
        <img class="p-result__img" alt="" src="{{ $reviewedBook->book->img }}" />
        <p class="p-result__title">{{ Str::limit($reviewedBook->book->title, 15) }}</p>
        <p class="p-result__review">レビュー件数： {{ $reviewedBook->review_count }}件</p>
        <div class="c-evaluation">
          <p class="c-evaluation__text">評価</p>
          <div class="c-evaluation__star" data-count="{{ $reviewedBook->evaluation_avg }}"></div>
        </div>
      </a>
    </li>
    @endforeach
  </ul>
  <div class="">{{ $reviewedBooks->links() }}</div>
  @else
  <div class="p-result-head">
    <h1 class="c-section__title"></h1>
    <ul class="p-result-head__tabs">
      <!-- <h2 class="p-result-head__tab js-release active-tabbtn" data-tab-trigger="release">新刊</h2>
      <h2 class="p-result-head__tab js-sales" data-tab-trigger="sales">売り上げ</h2> -->
      <h2 class="p-result-head__tab js-sales js-active-tabbtn" data-tab-trigger="sales">売り上げ</h2>
      <h2 class="p-result-head__tab js-release" data-tab-trigger="release">新刊</h2>
      <div id='result-line' class='sales'></div>
    </ul>
  </div>
  <!-- カテゴリ洗濯時 -->
  <ul class="p-result p-result-program p-books-lists"></ul>
  <ul class="p-result p-result-self"></ul>
  <ul class="p-result p-result-business"></ul>
  <ul class="p-result p-result-keyword"></ul>
  <!-- ページネーション -->
  <nav class="p-result-paginate">
    <ul class="pagination p-result-paginate__list"></ul>
  </nav>
  @endif
</div>

<script src="{{ asset('js/result.js') }}"></script>
<span id="js-getUrl" data-name="{{ Config::get('app.url') }}/review"></span>
<span id="js-getToken" data-name="{{ csrf_token() }}"></span>
<span id="js-getPath" data-name="{{ Config::get('app.rakuten_api_path') }}"></span>
<span id="js-search-query" data-name="{{ $category }}"></span>
<span id="js-condition" data-name="{{ $queryParams['condition'] ?? null }}"></span>
<span id="js-keyword" data-name="{{ $queryParams['keyword'] ?? null }}"></span>
<span id="js-page" data-name="{{ $queryParams['page'] ?? '1' }}"></span>
<span id="js-getId" data-name="{{ Config::get('app.rakuten_api_app_id') }}"></span>
<span id="js-getBaseUrl" data-name="{{ request()->url() }}"></span>
@endsection
