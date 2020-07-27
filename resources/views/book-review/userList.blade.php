@extends('layouts.common')

@section('content')
<div class="l-wrapper-inner p-userlist-wrapper">
  <div class="p-userlist-main">
    <div class="p-userlist-head">
      <h2 class="p-userlist-head-tabs active-tabbtn" data-tab-trigger="content1">ユーザー一覧</h2>
      <h2 class="p-userlist-head-tabs" data-tab-trigger="content2">ユーザーランキング</h2>
      <div id='line' class='content1'></div>
    </div>
    <div class="p-userlist-glance active-tabcontents" data-tab-target="content1">
      <ul class='p-userlist-glance-list'>
        @if($userInfos->isEmpty())
        <h1>検索結果がありませんでした。</h1>
        @else
        @foreach ($userInfos as $user)
        <li class="p-userlist-glance-item">
          <a href="{{ route('user', $user->id) }}" class="p-userlist-glance-item-link">
            @if (!empty($user->avatar))
            <img class="p-userlist-glance-item-link-img" src="{{ $user->avatar }}" alt="">
            @else
            <img class="p-userlist-glance-item-link-img" src="http://flat-icon-design.com/f/f_object_111/s512_f_object_111_2bg.png" alt="">
            @endif
            @if (in_array($user->id, $authUser->favorites->pluck('fav_user_id')->toArray()))
            <img class="p-userlist-glance-item-link-star" alt="" src="{{ asset('img/icon_star.png') }}">
            @elseif (\Carbon\Carbon::now()->subMonth()->lt($user->created_at))
            <img class="p-userlist-glance-item-link-star" alt="" src="{{ asset('img/icon_new.png') }}">
            @endif
          </a>
          <div class="p-userlist-glance-item-contents">
            <p class="p-userlist-glance-item-contents-name">{{ $user->name }}</p>
            @if(isset($user->userDetail->department->name))
            <p class="p-userlist-ranking-contents-depart">{{ $user->userDetail->department->name }}</p>
            @else
            <p class="p-userlist-ranking-contents-depart">非公開</p>
            @endif
            @if ($user->id !== Auth::id())
            <div>
              @if (in_array($user->id, $authUser->favorites->pluck('fav_user_id')->toArray()))
              <a href="javascript:void(0)" class="p-userlist-glance-item-contents-fav c-button-small favorites-flag is-remove">
                <p>お気に入り登録解除</p>
                <input type="hidden" class="favoriteId" data-favoriteid="{{ $user->id }}">
              </a>
              @else
              <a href="javascript:void(0)" class="p-userlist-glance-item-contents-fav c-button-small favorites-flag">
                <p>お気に入り登録</p>
                <input type="hidden" class="favoriteId" data-favoriteid="{{ $user->id }}">
              </a>
              @endif
            </div>
            @endif
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>

    <div class="p-userlist-ranking" data-tab-target="content2">
      <div class="p-userlist-ranking-section">
        <h3 class="p-userlist-ranking-section-head">総合ランキング</h3>
        <ul class="p-userlist-ranking-list">
          @foreach ($usersRanking as $user)
          <li class="p-userlist-ranking-item">
            <a href="{{ route('user', $user->id) }}" class="p-userlist-ranking-item-link">
              <span class="p-userlist-ranking-item-rank is-gold">{{ $loop->iteration }}</span>
              @if (!empty($user->avatar))
              <img class="p-userlist-glance-item-link-img" src="{{ $user->avatar }}" alt="">
              @else
              <img class="p-userlist-glance-item-link-img" src="http://flat-icon-design.com/f/f_object_111/s512_f_object_111_2bg.png" alt="">
              @endif
            </a>
            <div class="p-userlist-ranking-contents">
              <p class="p-userlist-ranking-contents-name">{{ $user->name }}</p>
              @if(isset($user->userDetail->department->name))
              <p class="p-userlist-ranking-contents-depart">{{ $user->userDetail->department->name }}</p>
              @else
              <p class="p-userlist-ranking-contents-depart">非公開</p>
              @endif
            </div>
          </li>
          @endforeach
        </ul>
      </div>
      <hr class="c-line">
      <div class="p-userlist-ranking-section">
        <h3 class="p-userlist-ranking-section-head">職業別ランキング</h3>
        <div class="p-userlist-ranking-section-category">
          <h4 class="p-userlist-ranking-section-category-smallhead">フロントエンドエンジニア</h4>
          <ul class="p-userlist-ranking-list">
            @foreach ($frontUsersRanking as $user)
            <li class="p-userlist-ranking-item">
              <a href="{{ route('user', $user->id) }}" class="p-userlist-ranking-item-link">
                <span class="p-userlist-ranking-item-rank is-gold">{{ $loop->iteration }}</span>
                @if (!empty($user->avatar))
                <img class="p-userlist-glance-item-link-img" src="{{ $user->avatar }}" alt="">
                @else
                <img class="p-userlist-glance-item-link-img" src="http://flat-icon-design.com/f/f_object_111/s512_f_object_111_2bg.png" alt="">
                @endif
              </a>
              <div class="p-userlist-ranking-contents">
                <p class="p-userlist-ranking-contents-name">{{ $user->name }}</p>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <hr class="c-line">
      <div class="p-userlist-ranking-section-category">
        <h4 class="p-userlist-ranking-section-category-smallhead">バックエンドエンジニア</h4>
        <ul class="p-userlist-ranking-list">
          @foreach ($backUsersRanking as $user)
          <li class="p-userlist-ranking-item">
            <a href="{{ route('user', $user->id) }}" class="p-userlist-ranking-item-link">
              <span class="p-userlist-ranking-item-rank is-gold">{{ $loop->iteration }}</span>
              @if (!empty($user->avatar))
              <img class="p-userlist-glance-item-link-img" src="{{ $user->avatar }}" alt="">
              @else
              <img class="p-userlist-glance-item-link-img" src="http://flat-icon-design.com/f/f_object_111/s512_f_object_111_2bg.png" alt="">
              @endif
            </a>
            <div class="p-userlist-ranking-contents">
              <p class="p-userlist-ranking-contents-name">{{ $user->name }}</p>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
      <hr class="c-line">
      <div class="p-userlist-ranking-section-category">
        <h4 class="p-userlist-ranking-section-category-smallhead">営業</h4>
        <ul class="p-userlist-ranking-list">
          @foreach ($salesUsersRanking as $user)
          <li class="p-userlist-ranking-item">
            <a href="{{ route('user', $user->id) }}" class="p-userlist-ranking-item-link">
              <span class="p-userlist-ranking-item-rank is-gold">{{ $loop->iteration }}</span>
              @if (!empty($user->avatar))
              <img class="p-userlist-glance-item-link-img" src="{{ $user->avatar }}" alt="">
              @else
              <img class="p-userlist-glance-item-link-img" src="http://flat-icon-design.com/f/f_object_111/s512_f_object_111_2bg.png" alt="">
              @endif
            </a>
            <div class="p-userlist-ranking-contents">
              <p class="p-userlist-ranking-contents-name">{{ $user->name }}</p>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  <aside class="p-userlist-side">
    {{ Form::open(['route' => 'userList', 'method' => 'GET']) }}
      <div class="p-userlist-side-section">
        <p class="p-userlist-side-head">ユーザー検索</p>
        {{ Form::text('keyword', $request->input('keyword'), ['placeholder' => 'キーワードを入力']) }}
        {{ Form::submit('') }}
      </div>
      <div class="p-userlist-side-section">
        <p class="p-userlist-side-head">絞り込み検索</p>
        <div class="p-userlist-side-section-refine">
          <p class="p-userlist-side-section-refine-head">入社年数</p>
          <div class="p-userlist-side-section-refine-contents">
            {{ Form::month('month', $request->input('month'), ['class' => 'btn']) }}
          </div>
          <p class="p-userlist-side-section-refine-head">職種</p>
          <div class="p-userlist-side-section-refine-contents">
            {{ Form::select('department', $departments, $request->input('department'), ['placeholder' => '選択して下さい']) }}
          </div>
          {{ Form::button('この条件で検索', ['class' => 'p-userlist-side-section-refine-contents-btn c-button', 'type' => 'submit']) }}
        </div>
      </div>
    {{ Form::close() }}
  </aside>
</div>

<script src="{{ asset('js/userList.js') }}"></script>
<span id="js-get-token" data-name="{{ csrf_token() }}"></span>
<span id="js-get-img-normal" data-name="{{ asset('img/icon_star.png') }}"></span>
@endsection
