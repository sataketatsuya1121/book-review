@extends('layouts.common')

@section('content')

<div class="l-wrapper-inner p-stocklist-wrapper">
  <h1 class="c-section__title p-stocklist__head">読みたい本リスト</h1>
  <ul class="p-stocklist__list">
    @if (filled($stocks))
    @foreach ($stocks as $stock)
    <li class="p-stocklist__item">
      <a class="p-stocklist__link" href="{{ route('detail', $stock->ISBN) }}">
        <img class="p-stocklist__img" src="{{ $stock->book->img }}">
      </a>
      <p class="p-stocklist__title">{{ Str::limit($stock->book->title, 40) }}</p>
    </li>
    @endforeach
    @else
    <p class="">読みたい本が追加されていません</p>
    @endif
  </ul>
</div>

@endsection
