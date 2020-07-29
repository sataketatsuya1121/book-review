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
        starList += '<span class="c-evaluation__star-icon is-form-star js-star-icon is-star-colord">★</span>';
      }
      for( var i = 0; i < normalStar; i++ ){
        starList += '<span class="c-evaluation__star-icon is-form-star js-star-icon">★</span>';
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
    $('.c-evaluation__star').each(function(){
      const int = $(this).data('count');
      const bint = 5 - int;
      for( var i = 0; i < int; i++ ){
          $(this).append('<span class="c-evaluation__star-icon a">★</span>');
          $('.a').addClass('is-star-colord');
      }
      for( var i = 0; i < bint; i++ ){
          $(this).append('<span class="c-evaluation__star-icon">★</span>');
      }
    })
  })

  $('input[type=file]').on('change', function() {
    const target = $(this).attr('id');
    const targetValue = $(this).val().replace(/^.*\\/, "");
    $('.js-' + target).text(targetValue);
  });

  $('[data-tab-trigger]').click(function(){
    var activeBtn = 'js-active-btn-user'
    var activeContents = 'js-active'
    var target = $(this).data('tab-trigger');

    $('#user-line').removeClass().addClass('#user-line').addClass(target);
    $('.js-active-btn-user').removeClass(activeBtn);
		$('[data-tab-trigger = ' + target + ']').addClass(activeBtn);
    $('.js-active').removeClass(activeContents);
			$('[data-tab-target = ' + target + ']').addClass(activeContents).hide().fadeIn(300);
  });

  let achievement = $('#js-archievement').data();
  if (achievement.name === 1) {
    $('.p-user-profile__title').prepend(`<div class="p-user-profile__goldrank p-user-profile__crown"></div>`);
  } else if (achievement.name === 2) {
    $('.p-user-profile__title').prepend(`<div class="p-user-profile__silverrank p-user-profile__crown"></div>`);
  } else if (achievement.name === 3) {
    $('.p-user-profile__title').prepend(`<div class="p-user-profile__bronzerank p-user-profile__crown"></div>`);
  } else {
    $('.p-user-profile__title').prepend(`<div class="p-user-profile__regularrank p-user-profile__crown"></div>`);
  }

  let csrf_token= $('#js-get-token').data();
  let img_normalicon =$('#js-get-img-normal').data();
  let img_goodicon =$('#js-get-img-good').data();
  $('.js-favorites-flag').each(function() {
    $(this).on('click', (e) => {
      var favoriteId = $(this).find('.favoriteId').data('favoriteid');
      if ($(this).hasClass('done')) {
        $.ajax({
          type: 'POST',
          url: '/review/' + favoriteId + '/unFavorite',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            favoriteId: favoriteId,
          },
          context: this,
        }).done(function(data) {
          if (data === 404) {
            console.log(data);
          } else {
            $(this).removeClass('done');
            $(this).children('img').attr('src', img_normalicon.name);
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(this).hasClass('done')) {
        $.ajax({
          type: 'POST',
          url: '/review/' + favoriteId + '/favorite',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            favoriteId: favoriteId,
          },
          context: this,
        }).done(function(data) {
          if (data === 404) {
            console.log(data);
          } else {
            $(this).addClass('done');
            $(this).children('img').attr('src', img_goodicon.name);
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  })
  

  $('.p-user-detailmodal__dot').on('click', function() {
    $('.p-user-dotbox').stop().fadeToggle(100);
  });

  $('.js-dotbox-delete').on('click', function () {
    $('.p-user-dotbox').fadeOut(100);
    $('.js-deletemodal').fadeIn(100);
  });

  $('.js-dotbox-cancel').on('click', function() {
    $('.p-user-dotbox , .js-deletemodal').fadeOut(100);
  });

  $('.js-edit-close').on('click', function() {
    $('.p-user-editmodal__bg').fadeOut();
    setTimeout(function() {
      $('.p-user-detailmodal__bg').show();
    },500);
  });

  $('.js-editmodal-back').on('click', function() {
    $('.p-user-editmodal__bg').hide();
    $('.p-user-detailmodal__bg').fadeIn();
  });

  $('.js-user-modal').on('click', function() {
    $('.js-user-deletemodal').fadeIn(300);
  });

  $('.js-modal-close').on('click', function() {
    $('.c-modal').fadeOut();
  });

  $('.js-modal-open').on('click', function() {
    let target = $(this).attr('data-target');
    targetModal = ".js-" + target + "-modal";
    console.log(targetModal);

    if(target === 'edit') {
      $('.p-user-dotbox').fadeOut(100);
      $('.p-user-detailmodal__bg').hide();
      $(targetModal).fadeIn(300);
    } else {
      $(targetModal).fadeIn(300);
    }
  });
});
