$(function() {

  // タブ切り替え
  $('[data-tab-trigger]').click(function(){
    var activeBtn = 'active-tabbtn'
    var activeContents = 'active-tabcontents'
    var target = $(this).data('tab-trigger');

    $('#line').removeClass().addClass('#line').addClass(target);
    $('.active-tabbtn').removeClass(activeBtn);
		$('[data-tab-trigger = ' + target + ']').addClass(activeBtn);
    $('.active-tabcontents').removeClass(activeContents);
			$('[data-tab-target = ' + target + ']').addClass(activeContents).hide().fadeIn(300);
  });

  let csrf_token= $('#js-get-token').data();
  let img_normalicon =$('#js-get-img-normal').data();
  let favoriteState = true;
  $('.favorites-flag').each(function() {
    $(this).on('click', (e) => {
      var favoriteId = $(this).find('.favoriteId').data('favoriteid');
      if ($(this).hasClass('is-remove') && favoriteState) {
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
            $(this).removeClass('is-remove');
            $(this).children('p').html('お気に入り登録');
            // $('.p-userlist-glance-item-link-star').attr('src', '');
            favoriteState = true;
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(this).hasClass('is-remove') && favoriteState) {
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
            $(this).addClass('is-remove');
            $(this).children('p').html('お気に入り登録解除');
            // $('.p-userlist-glance-item-link-star').attr('src', img_normalicon.name);
            favoriteState = true;
          }
        }).fail(function(msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  });

  //絞り込み年数
  var time = new Date();
  var year = time.getFullYear();
  for (var i = year; i >= 2015; i--) {
    $('#year').append('<option value="' + i + '">' + i + '</option>');
  }
  for (var i = 1; i <= 12; i++) {
    $('#month').append('<option value="' + i + '">' + i + '</option>');
  }
});
