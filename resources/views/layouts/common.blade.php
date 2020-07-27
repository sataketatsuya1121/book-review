<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;700;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <title>Book Review</title>
</head>
<body id="test">
	<header class="l-header">
		<div class="l-header-sidebar">
			<div class="l-header-barmenu">
				<div class="l-header-barmenu-bar"></div>
				<div class="l-header-barmenu-bar is-second"></div>
				<div class="l-header-barmenu-bar is-third"></div>
			</div>
			<div class="l-header-logo">
				<a href="{{ route('review') }}">
					<img src ="{{ asset('img/logo.png') }}">
				</a>
			</div>
		</div>
		<div class="l-header-search">
			<label>
				<input class="c-form-input-radio" type="radio"  name="condition"value="title" checked>
				<span><p>タイトル</p></span>
			</label>
			<label>
				<input class="c-form-input-radio" type="radio"  name="condition"value="author">
				<span><p>著者</p></span>
			</label>
			<label>
				<input class="c-form-input-radio" type="radio"  name="condition"value="publisher">
				<span><p>出版社</p></span>
			</label>
			<label>
				<p class="c-form-input-catogory">カテゴリ別</p>
			</label>
			<div class="l-header-search-box">
				<input type="text" name="keyword" placeholder="キーワードを入力">
				<input type="submit" value="">
			</div>
		</div>
		<div class="l-header-myarea">
			<a href="{{ route('logout') }}" class="l-header-myarea-icon">
				<img src="{{ asset('img/icon_login.png') }}">
			</a>

      {{-- 佐竹編集ここから --}}
      <div class="bell">
        <a class="l-header-myarea-icon bell-dropdown">
          <img src="{{ asset('img/icon_bell.png') }}" class="bell-icon">
        </a>
        <div class="bell-notifications" id="dropdown=menu">
          <button type="button" class="bell-allread">全て既読する</button>
          <ul class="bell-list">
          </ul>
        </div>
      </div>
      {{-- ここまで --}}

			<a href="{{ route('mypage') }}" class="l-header-myarea-icon-user">
				<img src="{{ Auth::user()->avatar ?: 'https://www.pondokindahmall.co.id/assets/img/default.png' }}" alt="">
			</a>
		</div>
	</header>
	<aside class="l-sidebar">
		<div class="l-sidebar-item">
			<a href="{{ route('review') }}" class="l-sidebar-item-home @if(Request::is('review')) nowlocation @endif">
				<img src="{{ asset('img/icon_home.png') }}">
				<span class="l-sidebar-item-text">ホーム</span>
			</a>
		</div>
		<div class="l-sidebar-item">
			<a href="{{ route('ranking') }}" class="l-sidebar-item-fire @if(Request::is('review/ranking')) nowlocation @endif">
				<img src="{{ asset('img/icon_fire.png') }}">
				<span class="l-sidebar-item-text">ランキング</span>
			</a>
		</div>
		<div class="l-sidebar-item">
			<a href="{{ route('newBook') }}" class="l-sidebar-item-sales @if(Request::is('review/new_book')) nowlocation @endif">
				<img src="{{ asset('img/icon_kirakira.png') }}">
				<span class="l-sidebar-item-text">新刊</span>
			</a>
		</div>
		<div class="l-sidebar-item">
			<a href="{{ route('userList') }}" class="l-sidebar-item-userlist @if(Request::is('review/user_list')) nowlocation @endif">
				<img src="{{ asset('img/icon_humans.png') }}">
				<span class="l-sidebar-item-text">ユーザー一覧</span>
			</a>
		</div>
		<div class="l-sidebar-item">
			<a href="{{ route('stockList') }}" class="l-sidebar-item-booklist @if(Request::is('review/stock_list')) nowlocation @endif">
				<img src="{{ asset('img/icon_books.png') }}">
				<span class="l-sidebar-item-text">読みたい本リスト</span>
			</a>
		</div>
	</aside>

	<main class="bg-whitegray">
			@yield ('content')
	</main>

	<footer class="l-footer-common">
		<div class="l-wrapper">
			<p class="l-footer-common-copy">copyright (c) 2020 Gizumo.inc all rights reserved.</p>
		</div>
  </footer>
  <span id="js-getToken" data-name="{{ csrf_token() }}"></span>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
