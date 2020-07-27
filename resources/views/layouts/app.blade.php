<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'BookReview') }}</title>

  <!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body id="test">
  <main class="bg-lightblue">
    @yield('content')
  </main>
  <footer class="l-footer">
    <div class="l-wrapper">
      <p class="l-footer-copy">copyright (c) 2020 Gizumo.inc all rights reserved.</p>
    </div>
  </footer>
	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>