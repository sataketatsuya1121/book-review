@extends('layouts.common')

@section('content')

<div class="l-wrapper-inner p-user-wrapper">
  <div class="p-user-profile">
    <div class="p-user-profile__img c-icon__img">
      <img src="{{ $user->avatar ?: 'https://www.pondokindahmall.co.id/assets/img/default.png' }}" alt="">
      <div class="p-user-profile__favarea">
        <!-- ↓こちら切り替えお願いします！ -->
        <a class="p-user-profile__fav c-button__small js-favorites-flag">
          <p>お気に入り登録</p>
          <input type="hidden" class="favoriteId" data-favoriteid="{{ $user->id }}">
        </a>
        <a class="p-user-profile__fav c-button__small js-favorites-flag is-remove">
          <p>お気に入り登録解除</p>
          <input type="hidden" class="favoriteId" data-favoriteid="{{ $user->id }}">
        </a>
      </div>
    </div>
    <div class="p-user-profile__status">
      <div class="p-user-profile__line c-icon__name p-user__text is-large">
        <p class="p-user-profile__name">{{ $user->name }}</p>
        @if ($user->id === Auth::id())
        <p class="p-user-profile__btn c-button__small js-modal-open" data-target="profile">プロフィールを変更する</p>
        @endif
      </div>
      <div class="p-user-profile__title">
        <span class="p-user__text is-middle">ランク</span>
        <span class="p-user__text is-middle">レビュー数  3件</span>
      </div>
      <table class="p-user-profile__info p-user-profile__table">
        @if (isset($userProfile))
        <tr>
          <th><p>誕生日</p></th>
          <td><p>{{ $userProfile->birthday }}</p></td>
        </tr>
        <tr>
          <th><p>入社年月</p></th>
          <td><p>{{ $userProfile->joined_company_date }}</p></td>
        </tr>
        @if(isset($userProfile->dept_id))
        <tr>
          <th><p>職種</p></th>
          <td><p>{{ $userProfile->department->name }}</p></td>
        </tr>
        @endif
        @if(isset($userProfile->lang))
        <tr>
          <th><p>知見のある言語</p></th>
          <td><p>{{ $userProfile->lang }}</p></td>
        </tr>
        @endif
        <tr>
          <th><p>自己紹介</p></th>
          <td><p>{{ $userProfile->introduce }}</p></td>
        </tr>
        @endif
      </table>
    </div>
  </div>
  <div class="p-user-review">
    <hr class="c-line">
    <div class="p-user-review__tab">
      <h2 class="c-section__mypage js-active-btn-user" data-tab-trigger="tab01">レビュー履歴</h2>
      @if ($user->id === Auth::id())
      <h2 class="c-section__mypage" data-tab-trigger="tab02">おすすめの本</h2>
      @endif
      <div id='user-line' class='tab01'></div>
    </div>
    @if (filled($user->reviews))
    <div class="p-user-review__lists js-active" data-tab-target="tab01">
      <ul class="p-user-review__review">
        @foreach ($user->reviews as $review)
        <li class="p-user-review__list">
          <img class="p-user-review__img js-modal-open"  data-target="detail" src="{{ $review->book->img }}" alt="">
          <p class="p-user-review__title">{{ Str::limit($review->book->title, 40) }}</p>
          <div class="c-evaluation p-user-review__evaluation">
            <div class="c-evaluation__stars">
              <div class="c-evaluation__star p-user-review__star" data-count="{{ $review->evaluation }}"></div>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
    @else
    <p class="c-err__mypage is-long active js-active" data-tab-target="tab01">レビュー履歴がありません</p>
    @endif
    @if ($user->id === Auth::id())
      @if (filled($user->stocks))
      <div class="p-user-review__lists" data-tab-target="tab02">
        <div class="p-user-review__recommend">
          <img src="../img/book-img.png" alt="">
          <p class="p-user__text is-middle">{{ $userProfile->ISBN }}</p>
        </div>
      </div>
      @else
      <p class="c-err__mypage is-long" data-tab-target="tab02">おすすめの本が追加されていません</p>
      @endif
    @endif
  </div>

  <!-- プロフィール編集modal -->
  <div class="c-modal js-modal js-profile-modal" @if ($errors->has('email')) style="display: block;" @endif>
    <div class="c-modal__bg p-user-profilemodal">
      <div class="c-modal__content">
        <a class="c-modal__close js-modal-close"></a>
        {{ Form::open(['route' => ['updateUser', $user->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) }}
          <table class="p-user-profilemodal__new p-user-profilemodal__table">
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">アイコン画像</p>
              </th>
              <td>
                {{ Form::file('avatar' , ['id' => 'file2']) }}
                <label for="file2" class="c-form__file">ファイルを選択</label>
                <label class="p-user-profilemodal__label js-file2">選択されていません</label>
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">名前</p>
              </th>
              <td>
                {{ Form::text('name', $user->name, ['class' => 'c-form__text js-form-input js-input-name', 'placeholder' => '入力してください']) }}
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">メールアドレス</p>
              </th>
              <td>
                {{ Form::email('email', $user->email, ['class' => 'c-form__text p-user-profilemodal__input js-form-input js-input-email', 'placeholder' => '入力してください']) }}
                <span id="input-email-err">@if ($errors->has('email')) {{ $errors->first('email') }} @endif</span>
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">生年月日</p>
              </th>
              <td>
                {{ Form::date('birthday', $userProfile ? $userProfile->birthday : null, ['class' => 'p-user-profilemodal__input', 'placeholder' => '選択して下さい']) }}
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">職種</p>
              </th>
              <td>
                {{ Form::select('dept_id', $departments, $userProfile ? $userProfile->dept_id : null, ['class' => 'p-user-profilemodal__input','placeholder' => '選択して下さい']) }}
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">入社年月</p>
              </th>
              <td>
                <input class="p-user-profilemodal__input" type="month" name="joined_company_date" value="{{ $userProfile ? $userProfile->joined_company_date : null }}">
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">知見のある言語</p>
              </th>
              <td>
                {{ Form::text('lang', $userProfile ? $userProfile->lang : null, ['class' => 'p-user-profilemodal__input']) }}
                <span id="input-name-err"></span>
              </td>
            </tr>
            <tr>
              <th>
                <p class="c-form__title p-user__text is-small">自己紹介</p>
              </th>
              <td>
                {{ Form::textarea('introduce', $userProfile ? $userProfile->introduce : null, ['class' => 'p-user-profilemodal__textarea','placeholder' => '入力してください']) }}
              </td>
            </tr>
          </table> 

          <div class="p-user-profilemodal__btns">
            <button type="button" class="c-button p-user-profilemodal__btn is-delete js-modal-open js-user-modal" data-target="user">アカウント削除</button>
            {{ Form::close() }}
            {{ Form::submit('更新する', ['class' => 'p-user-profilemodal__submit c-button p-user-profilemodal__btn js-form-submit']) }}
          </div>
      </div>
    </div>
  </div>

  <!-- レビュー詳細モーダル -->
  <div class="c-modal p-user-detailmodal js-detail-modal">
    <div class="c-modal__bg p-user-detailmodal__bg">
      <a class="c-modal__close p-user-detailmodal__close js-modal-close"></a>
      <a class="p-user-detailmodal__dot">…</a>
      <!-- 「…」を押したときに開くメニュー -->
      <div class="p-user-dotbox">
        <p class="p-user-dotbox__text js-dotbox-edit js-modal-open" data-target="edit">編集</p>
        <p class="p-user-dotbox__text is-delete js-dotbox-delete">削除</p>
        <p class="p-user-dotbox__text js-dotbox-cancel">キャンセル</p>
      </div>
      <!-- 「…」を押したときに開くメニュー -->
      <div class="c-modal__content p-user-detailmodal__content">
        <img src="../img/book-img.png">
        <div class="p-user-detailmodal__review">
          <div class="p-user-detailmodal__me">
            <div class="p-user-detailmodal__icon">
              @if (!empty($review->user->avatar))
              <img src="{{ $review->user->avatar }}" alt="">
              @else
              <img src="https://www.pondokindahmall.co.id/assets/img/default.png" alt="">
              @endif
            </div>
            <p class="c-icon__name p-user-detailmodal__name">{{ $review->user->name }}</p>
          </div>
          <div class="p-user-detailmodal__item">
            <p class="p-user-detailmodal__title">嫌われる勇気</p>
            <span class="p-user-detailmodal__author">著者：岸見一郎・古賀史健</span>
            <div class="p-user-detailmodal__datas">
              <div class="p-user-detailmodal__evaluation">
                <span class="p-user-detailmodal__tag">評価</span>
                <div class="c-evaluation__star p-user-detailmodal__star" data-count="{{ $review->evaluation }}"></div>
              </div>
              <span class="p-user-detailmodal__date">_{{ $review->created_at->format('Y/m/d') }}</span>
            </div>
          </div>
          <div class="p-user-detailmodal__item">
            <p class="p-user-detailmodal__text">ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- レビュー編集モーダル -->
    <div class="c-modal__bg p-user-editmodal__bg js-edit-modal">
      <div class="c-modal__content p-user-editmodal__content">
        {{ Form::open(['method' => 'put']) }}
          <a class="c-modal__close js-modal-close js-edit-close"></a>
          <a class="p-user-editmodal__back js-editmodal-back"></a>
          <div>
            <p class="c-form__title p-user-editmodal__evaluation">レビュー評価</p>
            <div class="c-evaluation__star p-user-editmodal__star">
              <span class="c-evaluation__star-icon is-form-star js-star-icon p-user-editmodal__staricon">★</span>
              <span class="c-evaluation__star-icon is-form-star js-star-icon p-user-editmodal__staricon">★</span>
              <span class="c-evaluation__star-icon is-form-star js-star-icon p-user-editmodal__staricon">★</span>
              <span class="c-evaluation__star-icon is-form-star js-star-icon p-user-editmodal__staricon">★</span>
              <span class="c-evaluation__star-icon is-form-star js-star-icon p-user-editmodal__staricon">★</span>
            </div>
            {{ Form::number('evaluation', null, ['class' => 'starIndexInput js-form-input js-input-star']) }}
            <span id="input-star-err"></span>
          </div>
          <div class="p-user-editmodal__detail">
            <p class="c-form__title p-user-editmodal__text">レビュー内容</p><span id="input-text-err"></span>
            {{ Form::textarea('content', null, ['class' => 'c-form__textbox is-review js-form-input js-input-text', 'placeholder' => 'テキストを入力してください。']) }}
            <br>
            <span class="c-modal__text-count"></span>
            {{ Form::submit('更新する', ['class' => 'c-button p-user-editmodal__submit js-form-submit']) }}
          </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>

  <!-- レビュー削除確認モーダル -->
  <div class="p-user-deletemodal js-deletemodal">
    <div class="p-user-deletemodal__content">
      <p class="p-user-deletemodal__text is-normal">投稿を削除しますか？</p>
      <p class="p-user-deletemodal__text is-delete js-dotbox-delete">削除</p>
      <p class="p-user-deletemodal__text js-dotbox-cancel">キャンセル</p>
    </div>
  </div>

  <!-- アカウント削除確認モーダル -->
  <div class="p-user-deletemodal js-user-deletemodal">
    <div class="p-user-deletemodal__content">
      <p class="p-user-deletemodal__text is-normal">アカウントを削除しますか？
      </p>
      <p class="p-user-deletemodal__text is-delete js-dotbox-delete">削除</p>
      <p class="p-user-deletemodal__text js-dotbox-cancel">キャンセル</p>
    </div>
  </div>

  <span id="js-archievement" data-name="{{ $achievement }}"></span>
  <script src="{{ asset('././js/user.js') }}"></script>
  <span id="js-get-token" data-name="{{ csrf_token() }}"></span>
  <span id="js-get-img-normal" data-name="{{ asset('img/good-icon-gray.png') }}"></span>
  <span id="js-get-img-good" data-name="{{ asset('img/good-icon.png') }}"></span>
</div>

@endsection
