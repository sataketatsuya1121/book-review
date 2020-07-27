@extends('layouts.common')
@section('content')
<div class="l-wrapper-inner p-detail-wrapper">
  <div class="p-detail-book">
    <div class="p-detail-book__img">
      <img src="{{ $book['mediumImageUrl'] }}" alt="">
    </div>
    <div class="p-detail-book__item">
      <p class="p-detail-book__title">{{ $book['title'] }}</p>
      <p class="p-detail-book__author">著者：{{ $book['author'] }}</p>
      <p class="p-detail-book__publish">出版社：{{ $book['publisherName'] }}</p>
    </div>
    @if (!empty($book['itemCaption']))
    <div class="p-detail-book__item">
      <p class="p-detail-book__title">あらすじ</p>
      <div class="p-detail-book__text">{{ $book['itemCaption'] }}</div>
    </div>
    @endif
    <div class="p-detail-book__item">
      <a href="{{ $book['itemUrl'] }}" class="p-detail-book__btn c-button-small is-sober" target="_blank">商品ページをみる</a>
      @if ($isMyStock)
      <a class="p-detail-book__btn c-button-small stock is-remove">
        リストから削除
      </a>
      @else
      <a class="p-detail-book__btn c-button-small stock">
        読みたい本リストに追加
      </a>
      @endif
      <!-- ↑のように切り替えできるようお願いします！ -->
      <a class="p-detail-book__btn c-button-small is-orange">おすすめの本に設定</a>
      <a class="p-detail-book__btn c-button-small is-remove">おすすめの本から削除</a>
    </div>
  </div>

  <div class="p-detail-reviews">
    <h2 class="c-section-title">レビュー一覧</h2>
    @if (empty($reviews->first()))
    <div class="c-err-card">
      <p class="c-err-card-msg">レビュー履歴がありません</p>
      <button class="c-button p-detail-reviews__btn is-first-review is-paused js-modal-open" data-target="post">投稿する</button>
    </div>
    @else
    <div class="back1 p-detail-reviews__sorts" scope="col" style="white-space:nowrap;">
      <p>@sortablelink('created_at', '新しい順', null, ['class' => Request::input('sort') === 'created_at' || Request::input('sort') === null ? 'sort-active disabled' : ''])</p>
      <p>@sortablelink('evaluation', '評価順', null, ['class' => Request::input('sort') === 'evaluation' ? 'sort-active disabled' : ''])</p>
      <p>@sortablelink('likes_count', 'いいね順', null, ['class' => Request::input('sort') === 'likes_count' ? 'sort-active disabled' : ''])</p>
    </div>
    @foreach ($reviews as $review)
    <div class="p-detail-reviews__item">
      <div class="p-detail-reviews__info">
        <a href="{{ route('user', $review->user->id) }}">
          <div class="c-icon-img p-detail-reviews__icon">
            @if (!empty($review->user->avatar))
            <img src="{{ $review->user->avatar }}" alt="">
            @else
            <img src="https://www.pondokindahmall.co.id/assets/img/default.png" alt="">
            @endif
          </div>
        </a>
        <p class="c-icon-name p-detail-reviews__name">{{ $review->user->name }}</p>
        <div class="p-detail-reviews__evaluation">
          <p class="p-detail-reviews__tag">評価</p>
          <div class="c-evaluation-star p-detail-reviews__star" data-count="{{ $review->evaluation }}"></div>
        </div>
        <p class="p-detail-reviews__date">_{{ $review->created_at->format('Y/m/d') }}</p>
      </div>
      <p class="p-detail-reviews__review">{!! nl2br(e($review->content)) !!}</p>
      <div class="p-detail-reviews__btnarea">
        <div class="p-detail-reviews__good review_good">
        @if (in_array(Auth::id(), $review->likes->pluck('user_id')->toArray()))
          <a href="javascript:void(0)" class="likes-flag done">
            <img src="{{ asset('img/good-icon.png') }}">
            <input type="hidden" class="reviewId" data-reviewid="{{ $review->id }}">
            <p class="likes-btn"></p>
          </a>
        @else
          <a href="javascript:void(0)" class="likes-flag">
            <img src="{{ asset('img/good-icon-gray.png') }}">
            <input type="hidden" class="reviewId" data-reviewid="{{ $review->id }}">
            <p class="likes-btn"></p>
          </a>
        @endif
          <p class="p-detail-reviews__goodmark">×</p>
          <p class="p-detail-reviews__count likes-count">{{ $review->likes_count }}</p>
        </div>
        <div class="p-detail-reviews__commentbtn-area">
          @if (!empty($review->comments->first()))
          <button class="c-button-small p-detail-reviews__commentbtn is-view js-comment-button" data-reviewid="{{ $review->id }}" data-text-default="コメントを見る" data-text-clicked="コメントを閉じる">
            コメントを見る
          </button>
          @else
          <button class="c-button-small p-detail-reviews__commentbtn js-comment-button" data-reviewid="{{ $review->id }}" style="display:none;" data-text-default="コメントを見る" data-text-clicked="コメントを閉じる">
            コメントを見る
          </button>
          @endif
          <button class="c-button-small js-modal-open js-comment-modal-open p-detail-reviews__commentbtn comment-post-button is-orange" data-reviewid="{{ $review->id }}" data-target="comment">
            コメントを投稿する
          </button>
        </div>
      </div>
    </div>
    <hr class="c-line">
    <div class="p-detail-comments">
      <ul class="comments" style="padding: 30px 40px 0 20px;">
        @foreach ($review->comments as $comment)
        <li class="p-detail-comments__item">
          <div class="c-icon p-detail-comments__info">
            <a href="{{ route('user', $comment->user->id) }}">
              <div class="c-icon-img p-detail-comments__icon">
                @if (!empty($comment->user->avatar))
                <img src="{{ $comment->user->avatar }}" alt="">
                @else
                <img src="https://www.pondokindahmall.co.id/assets/img/default.png" alt="">
                @endif
              </div>
            </a>
            <p class="c-icon-name p-detail-comments__name">{{ $comment->user->name }}</p>
            <p class="p-detail-comments__date">_{{ $review->created_at->format('Y/m/d') }}</p>
          </div>
          <p class="p-detail-comments__text">{!! nl2br(e($comment->content)) !!}</p>
          <!-- @if ($comment->user->id === Auth::id())
          {{ Form::open(['route' => ['editComment', $comment->id], 'method' => 'PUT']) }}
            {{ Form::textarea('content', $comment->content, ['class' => 'c-form-input-textbox p-detail-modal-detail-textbox js-comment-text js-form-input', 'placeholder' => 'テキストを入力してください。']) }}
            {{ Form::submit('編集したコメントを投稿する') }}
          {{ Form::close() }}
          {{ Form::open(['route' => ['deleteComment', $comment->id], 'method' => 'delete']) }}
            {{ Form::submit('削除する', ['class' => 'c-button is-danger']) }}
          {{ Form::close() }}
          @endif -->
        </li>
        @endforeach
      </ul>
    </div>
    @endforeach
    {{ $reviews->appends(Request::query())->links() }}
    @if (!$isMyReview)
    <button class="c-button p-detail-reviews__btn js-modal-open" data-target="post">投稿する</button>
    @else
    <button class="c-button p-detail-reviews__btn btn-disabled" disabled data-target="post">投稿済みです</button>
    @endif
    @endif
  </div>
</div>

<!-- modal -->
<div class="c-modal js-modal p-detail-modal js-post-modal">
  <div class="c-modal-bg p-detail-modal--bg">
    <div class="c-modal-content">
    {{ Form::open(['route' => ['createReview']]) }}
      {{ Form::hidden('ISBN', $book['isbn']) }}
      <a class="c-modal-close js-modal-close"></a>
      <div class="p-detail-modal__evaluation">
        <p class="c-form-input-title">評価</p>
        <div class="c-evaluation-star">
          <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
          <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
          <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
          <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
          <span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>
          {{ Form::number('evaluation', null, ['class' => 'starIndexInput js-form-input js-input-star']) }}
        </div>
        <span id="input-star-err"></span>
      </div>
      <div class="p-detail-modal__detail">
        <p class="c-form-input-title">内容</p><span id="input-text-err"></span>
        {{ Form::textarea('content', null, ['class' => 'c-form-input-textbox js-form-input js-input-text', 'placeholder' => 'テキストを入力してください。']) }}
        <br>
        <span class="c-modal-text-count"></span>
        {{ Form::submit('投稿する', ['class' => 'c-button p-detail-modal__btn js-form-submit js-form-submit-review']) }}
      </div>
    {{ Form::close() }}
    </div>
  </div>
</div>
<!-- modal -->

<!-- err-modal -->
<div class="c-modal js-modal js-err-modal">
  <div class="c-modal-bg p-detail-err--bg">
    <div class="c-modal-content p-detail-err__content">
      <a class="c-modal-close js-modal-close"></a>
        <p class="p-detail-err__message">すでに投稿されています</p>
    </div>
  </div>
</div>
<!-- err-modal -->

<!-- modal-comment -->
<div class="c-modal js-modal p-detail-modal js-comment-modal">
  <div class="c-modal-bg p-detail-modal--bg">
    <div class="c-modal-content">
    {{ Form::open(['route' => ['postComment'], 'method' => 'POST']) }}
      {{ Form::hidden('ISBN', $book['isbn']) }}
      {{ Form::hidden('review_id', null, ['class' => 'comment-review-id']) }}
      <a class="c-modal-close js-modal-close"></a>
      <div class="p-detail-modal__detail">
        <p class="c-form-input-title">内容</p><span id="input-comment-err"></span>
        {{ Form::textarea('content', null, ['class' => 'c-form-input-textbox js-comment-text js-form-input', 'placeholder' => 'テキストを入力してください。']) }}
        <br>
        <span class="c-modal-comment-count"></span>
        {{ Form::submit('コメントを投稿する', ['class' => 'c-button p-detail-modal__btn js-form-submit-comment js-form-submit is-orange']) }}
      </div>
    {{ Form::close() }}
    </div>
  </div>
</div>
<!-- modal-comment -->

<script src="{{ asset('js/detail.js') }}"></script>
<span id="js-get-token" data-name="{{ csrf_token() }}"></span>
<span id="js-get-img-normal" data-name="{{ asset('img/good-icon-gray.png') }}"></span>
<span id="js-get-img-good" data-name="{{ asset('img/good-icon.png') }}"></span>
<span id="js-get-stock" data-name="{{ $book['isbn'] }}"></span>
@endsection
