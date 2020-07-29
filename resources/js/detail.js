$(function() {

  let csrf_token= $('#js-get-token').data();
  let img_normalicon =$('#js-get-img-normal').data();
  let img_goodicon =$('#js-get-img-good').data();
  let stock_readbook =$('#js-get-stock').data();

  $(document).ready( function() {
    $('.c-evaluation__star').each(function() {
      const evaluation = $(this).data('count');
      const normalStar = 5 - evaluation;
      var starList = '';
      for ( var i = 0; i < evaluation; i++ ) {
        starList += '<span class="c-evaluation__star-icon js-star-icon is-star-colord">★</span>';
      }
      for ( var i = 0; i < normalStar; i++ ) {
        starList += '<span class="c-evaluation__star-icon js-star-icon">★</span>';
      }
      $(this).append(starList);
    })
  })

  $('.likes-flag').each(function() {
    $(this).on('click', (e) => {
      var reviewId = $(this).find('.reviewId').data('reviewid');
      var likesCount = parseInt($(this).nextAll('.likes-count').text());
      if ($(this).hasClass('done')) {
        $.ajax({
          type: 'POST',
          url: '/review/' + reviewId + '/unLike',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            reviewId: reviewId,
          },
          context: this,
        }).done(function(data) {
          if (data === 404) {
            console.log(data);
          } else {
            $(this).removeClass('done');
            $(this).nextAll('.likes-count').text(likesCount -= 1);
            $(this).children('img').attr('src', img_normalicon.name);
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(this).hasClass('done')) {
        $.ajax({
          type: 'POST',
          url: '/review/' + reviewId + '/like',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            reviewId: reviewId,
          },
          context: this,
        }).done(function(data) {
          if (data === 404) {
            console.log(data);
          } else {
            $(this).addClass('done');
            $(this).nextAll('.likes-count').text(likesCount += 1);
            $(this).children('img').attr('src', img_goodicon.name);
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  })

  //ソート機能のcss付け替え
  $('.p-detail-columns-reviews-sorts p').on('click', function() {
    $('.p-detail-columns-reviews-sorts p').removeClass('sort-active');
    $(this).addClass('sort-active');
  });
  $('.c-modal__close').on('click', function() {
    $('.js-form-input').val(null);
    $('.js-star-icon').removeClass('is-star-colord');
  });

  //ストック機能
  var isbn = stock_readbook.name;
  $('.stock').on('click', function() {
    if ($(this).hasClass('is-remove')) {
      $.ajax({
        type: 'DELETE',
        url: '/review/' + isbn + '/unstock',
        dataType: 'json',
        data: {
          _token: csrf_token.name,
          isbn: isbn,
        },
        context: this,
      }).done(function(data) {
        $(this).removeClass('is-remove');
        $(this).text('読みたい本リストに追加');
      }).fail(function(msg) {
        console.log('NG' + msg.responseText);
      });
    } else if (!$(this).hasClass('is-remove')) {
      $.ajax({
        type: 'POST',
        url: '/review/' + isbn + '/stock',
        dataType: 'json',
        data: {
          _token: csrf_token.name,
          isbn: isbn,
        },
        context: this,
      }).done(function(data) {
        $(this).addClass('is-remove');
        $(this).text('リストから削除');
      }).fail(function(msg) {
        console.log('NG' + msg.responseText);
      });
    }
  });

  //レビューにコメントする機能
  $('.comment-post-button').on('click', function() {
    var reviewId = $(this).data('reviewid');
    $('.comment-review-id').val(reviewId);
  });
  $('.comments').hide();
  $('.js-comment-button').each(function(index) {
    var i = index;
    $(this).attr('id', 'js-' + i + '-comment-button');
    var button = '#js-' + i + '-comment-button';
    $(button).on('click', function() {
      var comments = '.js-' + i + '-comments';
      $(comments).slideToggle();
    });
  });
  $('.comments').each(function(index) {
    var i = index;
    $(this).attr('class', 'js-' + i + '-comments');
    var comments = 'js-' + i + '-comments';
  });

  $('.is-view').on('click', function () {
    $(this).toggleClass('active');

    if($(this).hasClass('active')){
        var text = $(this).data('text-clicked');
    } else {
        var text = $(this).data('text-default');
    }
    $(this).html(text);
  });

    //おすすめ本機能
    var isbn = stock_readbook.name;
    $('.recommend').on('click', function() {
      if ($(this).hasClass('is-remove')) {
        $.ajax({
          type: 'DELETE',
          url: '/review/' + isbn + '/unRecommend',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            isbn: isbn,
          },
          context: this,
        }).done(function(data) {
          if (data === 404) {
            console.log(data);
          } else {
            $(this).removeClass('is-remove');
            $(this).addClass('is-orange');
            $(this).text('おすすめの本に設定');
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(this).hasClass('is-remove')) {
        $.ajax({
          type: 'POST',
          url: '/review/' + isbn + '/recommend',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            isbn: isbn,
          },
          context: this,
        }).done(function(data) {
          $(this).removeClass('is-orange');
          $(this).addClass('is-remove');
          $(this).text('おすすめの本から削除');
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
});
