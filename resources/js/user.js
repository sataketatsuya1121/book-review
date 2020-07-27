$(function(){
  $(document).on('click', '.js-star-icon', function() {
    $(this).parent().children('.js-star-icon').removeClass('is-star-colord');
    var starIndex = $(this).index();
    for ( var i = 0; i <= starIndex; i++) {
      $(this).parent().children(`.js-star-icon:eq(${i})`).addClass('is-star-colord');
    }
    $('.starIndexInput').val(starIndex + 1);
  })

  $('.is-edit').click(function(){
    var url = $(this).data('url');
    var content = $(this).data('content');
    var evaluation = $(this).data('evaluation');
    $('form').attr('action', url);
    $('.p-detail-modal-detail-textbox').val(content);
    $('.starIndexInput').val(evaluation);
    $('.p-user-modal-evaluation-star').each(function(){
      const normalStar = 5 - evaluation;
      var starList = '';
      for( var i = 0; i < evaluation; i++ ){
        starList += '<span class="c-evaluation-star-icon is-form-star js-star-icon is-star-colord">★</span>';
      }
      for( var i = 0; i < normalStar; i++ ){
        starList += '<span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>';
      }
      $(this).html(starList);
    })
  })

  $('.p-user-review-btn-delete').click(function(){
    var url = $(this).data('url');
    $('form').attr('action', url);
  });

  $('.p-user-stock-btn-delete').click(function(){
    var url = $(this).data('url');
    $('form').attr('action', url);
  });

  $(document).ready(function() {
    $('.c-evaluation-star').each(function(){
      const int = $(this).data('count');
      const bint = 5 - int;
      for( var i = 0; i < int; i++ ){
          $(this).append('<span class="c-evaluation-star-icon a">★</span>');
          $('.a').addClass('is-star-colord');
      }
      for( var i = 0; i < bint; i++ ){
          $(this).append('<span class="c-evaluation-star-icon">★</span>');
      }
    })
  })

  $('input[type=file]').on('change', function() {
    const target = $(this).attr('id');
    const targetValue = $(this).val().replace(/^.*\\/, "");
    $('.js-' + target).text(targetValue);
  });

  var active = 'js-active';
  var activeBtn = 'js-active-btn-user'
  $('[data-tab-trigger]').on('click', function() {
    $('.js-active-btn-user').removeClass(activeBtn);
    $(this).addClass(activeBtn);
    var target = $(this).data('tab-trigger');
    $('.js-active').removeClass(active);
    $('[data-tab-target = ' + target + ']').addClass(active).hide().fadeIn(500);
  });

  let achievement = $('#js-archievement').data();
  if (achievement.name === 1) {
    $('.p-user-status-title').append(`<div class="p-user-status-title-gold-img p-user-is-img"></div>`);
    $('.p-user-status-title').append(`<p class="p-user-status-title-gold p-user-is-title">ゴールドランク</p>`);
  } else if (achievement.name === 2) {
    $('.p-user-status-title').append(`<div class="p-user-status-title-silver-img p-user-is-img"></div>`);
    $('.p-user-status-title').append(`<p class="p-user-status-title-silver p-user-is-title">シルバーランク</p>`);
  } else if (achievement.name === 3) {
    $('.p-user-status-title').append(`<div class="p-user-status-title-bronze-img p-user-is-img"></div>`);
    $('.p-user-status-title').append(`<p class="p-user-status-title-bronze p-user-is-title">ブロンズランク</p>`);
  } else {
    $('.p-user-status-title').append(`<div class="p-user-status-title-regular-img p-user-is-img"></div>`);
    $('.p-user-status-title').append(`<p class="p-user-status-title-regular p-user-is-title">レギュラーランク</p>`);
  }

  let csrf_token= $('#js-get-token').data();
  let img_normalicon =$('#js-get-img-normal').data();
  let img_goodicon =$('#js-get-img-good').data();
  let favoriteState = true;
  $('.favorites-flag').each(function() {
    $(this).on('click', (e) => {
      var favoriteId = $(this).find('.favoriteId').data('favoriteid');
      if ($(this).hasClass('done') && favoriteState) {
        favoriteState = false;
        $.ajax({
          type: 'POST',
          url: '/review/' + favoriteId + '/unFavorite',
          dataType: 'json',
          data: { _token: csrf_token.name, favoriteId: favoriteId },
          context: this,
        }).done(function(data) {
          if (data == '404') {
            console.log('404');
          } else {
            $(this).removeClass('done');
            $(this).children('img').attr('src', img_normalicon.name);
            favoriteState = true;
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(this).hasClass('done') && favoriteState) {
        favoriteState = false;
        $.ajax({
          type: 'POST',
          url: '/review/' + favoriteId + '/favorite',
          dataType: 'json',
          data: { _token: csrf_token.name, favoriteId: favoriteId },
          context: this,
        }).done(function(data) {
          if (data == '404') {
            console.log('404');
          } else {
            $(this).addClass('done');
            $(this).children('img').attr('src', img_goodicon.name);
            favoriteState = true;
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  })
});
