@extends('layouts.common')

@section('content')

<div class="l-wrapper-inner p-user-wrapper">
	<div class="p-user-profile">
	@if ($user->id === Auth::id())
	<p class="c-button-small p-user-profile-btn js-modal-open" data-target="profile">プロフィールを変更する</p>
	@endif
  <div class="p-user-header">
    <img src="{{ $user->header ?: 'https://agriot.info/wp-content/uploads/2018/11/bg-09-free-img.jpg' }}" alt="">
  </div>
  <div class="p-user-icon">
    <div class="p-user-icon-img c-icon-img">
      <img src="{{ $user->avatar ?: 'https://www.pondokindahmall.co.id/assets/img/default.png' }}" alt="">
    </div>
    <div class="p-user-status">
      <div class="p-user-status-name c-icon-name">
        <p class="p-user-status-name-text">{{ $user->name }}</p>

        {{-- プロフィール充実化 frontさんへ--}}
        @if (isset($userProfile))
        <p class="p-user-status-name-text">{{ $userProfile->birthday }}</p>
        <p class="p-user-status-name-text">{{ $userProfile->joined_company_date }}</p>
        <p class="p-user-status-name-text">{{ $userProfile->ISBN }}</p>
        <p class="p-user-status-name-text">{{ $userProfile->introduce }}</p>
          @if(isset($userProfile->lang_id))
          <p class="p-user-status-name-text">{{ $userProfile->language->name }}</p>
          @endif
          @if(isset($userProfile->dept_id))
          <p class="p-user-status-name-text">{{ $userProfile->department->name }}</p>
          @endif
        @endif
{{-- プロフィール追加 ここまで--}}

      </div>
      <div class="p-user-status-title"></div>
      @if ($user->id !== Auth::id())
      <div>
        @if ($authFavorited)
        <a href="javascript:void(0)" class="favorites-flag done">
          <img src="{{ asset('img/good-icon.png') }}">
          <input type="hidden" class="favoriteId" data-favoriteid="{{ $user->id }}">
        </a>
        @else
        <a href="javascript:void(0)" class="favorites-flag">
          <img src="{{ asset('img/good-icon-gray.png') }}">
          <input type="hidden" class="favoriteId" data-favoriteid="{{ $user->id }}">
        </a>
        @endif
      </div>
      @endif
    </div>
  </div>
</div>

<div class="p-user-review-inner">
  <h2 class="c-section-title-mypage js-active-btn-user" data-tab-trigger="tab01">レビュー履歴</h2>
  @if ($user->id === Auth::id())
  <h2 class="c-section-title-mypage" data-tab-trigger="tab02">読みたい本リスト</h2>
  @endif
  @if (filled($user->reviews))
  <ul class="p-user-review-lists js-active" data-tab-target="tab01">
    @foreach ($user->reviews as $review)
    <hr class="p-user-review-lists-list-line">
    <li class="p-user-review-list">
      <div class="p-user-review-book-img">
        <a href="{{ route('detail', $review->ISBN) }}" class="p-user-review-book-img-link"><img src="{{ $review->book->img }}" alt=""></a>
      </div>
      <div class="p-user-review-book-content">
        <p class="p-user-review-book-ttl">{{ Str::limit($review->book->title, 40) }}</p>
        <p class="p-user-review-book-author">著者：{{ $review->book->author }}</p>
        <div class="c-evaluation p-user-review-evaluation">
          <div class="c-evaluation-stars">
            <p class="c-evaluation-txt">評価</p>
            <div class="c-evaluation-star" data-count="{{ $review->evaluation }}">
            </div>
          </div>
          <p class="c-evaluation-date">- {{ $review->created_at->format('Y/m/d') }}</p>
        </div>
        <p class="p-user-review-book-txt">
          {!! nl2br(e($review->content)) !!}
        </p>
      </div>
      @if ($user->id === Auth::id())
      <div class="p-user-review-btns">
        <p class="c-button-small is-edit js-modal-open" data-target="edit" data-url="{{ route('updateReview', $review->id) }}" data-content="{{ $review->content }}" data-evaluation="{{ $review->evaluation }}">
        編集
        </p>
        <p class=" c-button-small is-danger p-user-review-btn-delete js-modal-open" data-target="delete" data-url="{{ route('destroyReview', $review->id) }}">
          削除
        </p>
      </div>
      @endif
    </li>
    @endforeach
  </ul>
  @else
  <p class="c-err-card-mypage is-long active js-active" data-tab-target="tab01">レビュー履歴がありません</p>
  @endif

  @if ($user->id === Auth::id())
    @if (filled($user->stocks))
    <ul class="p-user-review-lists" data-tab-target="tab02">
      @foreach ($user->stocks as $stock)
      <hr class="p-user-review-lists-list-line">
      <li class="p-user-review-list">
        <div class="p-user-review-book-img">
          <a href="{{ route('detail', $stock->ISBN) }}" class="p-user-review-book-img-link"><img src="{{ $stock->book->img }}" alt=""></a>
        </div>
        <div class="p-user-review-book-content">
          <p class="p-user-review-book-ttl">{{ Str::limit($stock->book->title, 40) }}</p>
          <p class="p-user-review-book-author">著者：{{ $stock->book->author }}</p>
          <div class="c-evaluation p-user-review-evaluation">
            <p class="c-evaluation-date-readbookList">- {{ $stock->created_at->format('Y-m-d') }}</p>
          </div>
        </div>
        <div class="p-user-review-btns">
          <p class=" c-button-small is-danger p-user-stock-btn-delete js-modal-open" data-target="delete" data-url="{{ route('unstockMypage', $stock->ISBN) }}">
            削除
          </p>
        </div>
      </li>
      @endforeach
    </ul>
    @else
    <p class="c-err-card-mypage is-long" data-tab-target="tab02">読みたい本が追加されていません</p>
    @endif
  @endif
</div>

<div class="c-modal js-modal p-uesr-modal js-edit-modal">
	<div class="c-modal-bg p-user-modal-bg">
		<div class="c-modal-content p-user-modal-content">
			{{ Form::open(['method' => 'put']) }}
        <a class="c-modal-close js-modal-close"></a>
        <div class="p-user-modal-evaluation">
          <p class="c-form-input-title">評価</p>
          <div class="c-evaluation-star p-user-modal-evaluation-star">
            <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
            <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
            <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
            <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
            <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
          </div>
          {{ Form::number('evaluation', null, ['class' => 'starIndexInput js-form-input js-input-star']) }}
          <span id="input-star-err"></span>
        </div>
        <div class="p-user-modal-detail">
          <p class="c-form-input-title">内容</p><span id="input-text-err"></span>
          {{ Form::textarea('content', null, ['class' => 'c-form-input-textbox is-review p-detail-modal-detail-textbox js-form-input js-input-text', 'placeholder' => 'テキストを入力してください。']) }}
          <br>
          <span class="c-modal-text-count"></span>
          {{ Form::submit('更新する', ['class' => 'c-button p-user-update-submit js-form-submit']) }}
        </div>
		  {{ Form::close() }}
    </div>
  </div>
</div>

<div class="c-modal is-delete js-modal js-delete-modal">
  <div class="c-modal-bg p-user-delete-bg">
    <div class="c-modal-content p-user-delete-content">
      <a class="c-modal-close js-modal-close"></a>
				<p class="p-user-delete-message">削除しますか？</p>
				<div class="p-user-delete-btns">
				  {{ Form::open(['method' => 'delete']) }}
					  {{ Form::submit('削除する', ['class' => 'c-button is-danger p-user-delete-btns is-enter js-loading']) }}
				  {{ Form::close() }}
					<p class="c-button is-back p-user-delete-btns is-back js-modal-close">戻る</p>
				</div>
    </div>
  </div>
</div>

<div class="c-modal js-modal js-profile-modal" @if ($errors->has('email')) style="display: block;" @endif>
  <div class="c-modal-bg">
    <div class="c-modal-content p-user-profile-update">
			<a class="c-modal-close js-modal-close"></a>
			{{ Form::open(['route' => ['updateUser', $user->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) }}
				<div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">ヘッダー画像変更</p>
					<div class="p-user-profile-update-input">
						{{ Form::file('header',  ['id' => 'file1']) }}
						<label for="file1" class="c-form-input-file">ファイルを選択</label>
						<label class="c-form-input-file-name js-file1">選択されていません</label>
					</div>
				</div>
				<div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">アイコン画像変更</p>
					<div class="p-user-profile-update-input">
						{{ Form::file('avatar' , ['id' => 'file2']) }}
						<label for="file2" class="c-form-input-file">ファイルを選択</label>
						<label class="c-form-input-file-name js-file2">選択されていません</label>
					</div>
				</div>

				<div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">名前変更</p>
					<div class="p-user-profile-update-input">
						{{ Form::text('name', $user->name, ['class' => 'c-form-input-text p-user-profile-update-content js-form-input js-input-name', 'placeholder' => '入力してください']) }}
					</div>
        </div>

{{-- プロフィール充実化 frontさんへ--}}
        <div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">生年月日</p>
					<div class="p-user-profile-update-input">
						{{ Form::date('birthday', $userProfile ? $userProfile->birthday : null, ['placeholder' => '選択して下さい']) }}
					</div>
        <div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">入社年月</p>
					<div class="p-user-profile-update-input">
						{{ Form::date('joined_company_date',  $userProfile ? $userProfile->joined_company_date : null, ['placeholder' => '選択して下さい']) }}
          </div>
        </div>
        <div class="p-user-profile-update-box">
          <p class="c-form-input-title p-user-profile-update-title">部署</p>
            {{ Form::select('dept_id', $departments, $userProfile ? $userProfile->dept_id : null, ['placeholder' => '選択して下さい']) }}
          </div>
        </div>
        <div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">知見のある言語</p>
					<div class="p-user-profile-update-input">
						{{ Form::select('lang_id', $languages, $userProfile ? $userProfile->lang_id : null, ['placeholder' => '選択して下さい']) }}
					</div>
        </div>
					<p class="c-form-input-title p-user-profile-update-title">自己紹介</p>
            {{ Form::textarea('introduce', $userProfile ? $userProfile->introduce : null, ['placeholder' => '入力してください']) }}
{{-- プロフィール追加モーダル ここまで--}}

				<span id="input-name-err"></span>
				<div class="p-user-profile-update-box">
					<p class="c-form-input-title p-user-profile-update-title">メールアドレス変更</p>
					<div class="p-user-profile-update-input">
						{{ Form::email('email', $user->email, ['class' => 'c-form-input-text p-user-profile-update-content js-form-input js-input-email', 'placeholder' => '入力してください']) }}
					</div>
				</div>

				<span id="input-email-err">@if ($errors->has('email')) {{ $errors->first('email') }} @endif</span>
				<div class="p-user-profile-update-btns">
					<button type="button" class="c-button is-back js-modal-close p-user-profile-update-back is-black js-modal-close">戻る</button>
					{{ Form::submit('更新する', ['class' => 'p-user-profile-update-submit c-button js-form-submit']) }}
				</div>
				<button type="button" class="c-button is-hide p-user-profile-update-delete js-modal-open" data-target="user">アカウント削除</button>
			{{ Form::close() }}
    </div>
  </div>
</div>

<div class="c-modal is-delete js-modal js-user-modal">
  <div class="c-modal-bg p-user-delete-bg">
    <div class="c-modal-content p-user-delete-content">
      <a class="c-modal-close js-modal-back"></a>
				<p class="p-user-delete-message">アカウントを削除しますか？</p>
				<div class="p-user-delete-btns">
          {{ Form::open(['route' => 'destroyUser', 'method' => 'delete']) }}
            {{ Form::submit('削除する', ['class' => 'c-button is-danger p-user-delete-btns is-enter js-modal-close js-loading']) }}
          {{ Form::close() }}
					<p class="c-button is-back p-user-delete-btns is-back js-modal-back">戻る</p>
				</div>
    </div>
  </div>
</div>
<span id="js-archievement" data-name="{{ $achievement }}"></span>
<script src="{{ asset('././js/user.js') }}"></script>
<span id="js-get-token" data-name="{{ csrf_token() }}"></span>
<span id="js-get-img-normal" data-name="{{ asset('img/good-icon-gray.png') }}"></span>
<span id="js-get-img-good" data-name="{{ asset('img/good-icon.png') }}"></span>

@endsection
