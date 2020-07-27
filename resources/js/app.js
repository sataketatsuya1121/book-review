import Validator from 'validatorjs';
import Echo from 'laravel-echo';

$(function(){

   //iosの判別と、使用ブラウザがsafariのときの判別
   const isIOS = /iP(hone|(o|a)d)/.test(navigator.userAgent);
   const ua = window.navigator.userAgent.toLowerCase();
   const isSafari = ua.indexOf('safari') !== -1 && ua.indexOf('chrome') === -1 && ua.indexOf('edge') === -1;

  //通知アイコン
  let dropState = false;
  $('.bell-dropdown').click(function() {
    if (dropState) {
      $('.bell-notifications').removeClass('bell-active');
      dropState = false;
    } else {
      $('.bell-notifications').addClass('bell-active');
      dropState = true;
    }
  });

  //ハンバーガーメニュー
  let menuState = false;
  $('#header-menu-btn').click(function() {
    if(menuState) {
      $('.l-header-bar-first').removeClass('rotate-bar');
      $('.l-header-bar-middle').removeClass('bar-none');
      $('.l-header-bar-last').removeClass('rotate-bar-reverse');
      $('#header-menu').fadeOut(500);
      menuState = false;
    } else {
      $('.l-header-bar-first').addClass('rotate-bar');
      $('.l-header-bar-middle').addClass('bar-none');
      $('.l-header-bar-last').addClass('rotate-bar-reverse');
      $('#header-menu').fadeIn(500);
      menuState = true;
    }
  });

  $('main , .l-header-form-inner , footer').on('click', function() {
    if ($('.l-header-menus').is(':visible')) {
      $('.l-header-bar-first').removeClass('rotate-bar');
      $('.l-header-bar-middle').removeClass('bar-none');
      $('.l-header-bar-last').removeClass('rotate-bar-reverse');
      $('#header-menu').fadeOut(500);
      menuState = false;
    }
  });

  //投稿画面で、クリックされた星の部分まで色を付ける
  $('.js-star-icon').click(function() {
    $(this).parent().children('.js-star-icon').removeClass('is-star-colord');
    var starIndex = $(this).index();
    for ( var i = 0; i <= starIndex; i++) {
      $(this).parent().children(`.js-star-icon:eq(${i})`).addClass('is-star-colord');
    }
    $(this).siblings('.starIndexInput').val(starIndex + 1);
  });

  //scrollTop
  $(window).scroll(function() {
    if($(this).scrollTop() > 100) {
      $('#scroll-top').fadeIn(300);
    } else {
      $('#scroll-top').fadeOut(300);
    }
  });
  $('#scroll-top').click(function() {
    $('body,html').animate({scrollTop: 0},500);
  });

  // modal
  let scrollPosition;
  let targetModal = "";
  let currentTextLength;
  let currentCommentLength;
  let deleteModalState;

  // bodyのスクロール固定
  function bodyFixedOn() {
    if(isIOS || isSafari){
        scrollPosition = $(window).scrollTop();
        $('body').css('position', 'fixed');
        $('body').css('top', '-' + scrollPosition + 'px');
    }else {
        $('body').addClass('is-modal-open');
    }
  }
  //bodyのスクロール固定を解除
  function bodyFixedOff() {
    if(isIOS || isSafari){
      if(deleteModalState) {
        deleteModalState = false;
        return;
      }
      $('body').css('position', '');
      $('body').css('top', '');
      $(window).scrollTop(scrollPosition);
    }else {
      if(deleteModalState) {
        deleteModalState = false;
        return;
      }
      $('body').removeClass('is-modal-open');
    }
  }

  $('.js-modal-open').on('click', (e) => {
    bodyFixedOn();
    $('.c-modal-err').html('');
    let $this = $(e.currentTarget);
    let target = $this.attr('data-target');
    targetModal = ".js-" + target + "-modal";
    if(targetModal === '.js-user-modal') {
      deleteModalState = true;
    }
    $(targetModal).fadeIn(500);
    $('.is-first-review').addClass('is-paused');

    currentTextLength = $('.js-input-text').val().length;
    currentCommentLength = $('.js-comment-text').val().length;

    $('.c-modal-text-count').html(currentTextLength + "/1000文字");
    $('.c-modal-comment-count').html(currentCommentLength + "/1000文字");
  });

  $(".js-modal-close").on('click', (e) => {
    $(targetModal).fadeOut(300);
    bodyFixedOff();
    $('.is-first-review').removeClass('is-paused');
    let $this = $(e.currentTarget);
    $this.parents('.js-modal').fadeOut(300);
  });

  $(".js-modal-back").on('click', (e) => {
    bodyFixedOff();
    $(targetModal).fadeOut(300);
    $('.is-first-review').removeClass('is-paused');
    let $this = $(e.currentTarget);
    $this.parents('.js-modal').fadeOut(300);
  });

  $('.js-input-text').bind('keydown keyup keypress change',function(){
    currentTextLength = $(this).val().length;
    $('.c-modal-text-count').html(currentTextLength + "/1000文字");
  });

  $('.js-comment-text').bind('keydown keyup keypress change',function(){
    currentCommentLength = $(this).val().length;
    $('.c-modal-comment-count').html(currentCommentLength + "/1000文字");
  });

  $('.js-loading').on('click', (e) => {
    $('.c-modal').append('<div id="submit-loading" class="loading"></div>');
  });

  //headerの検索パラメータ保持
  //urlのパラメータを取得
  function getParam(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }
  const searchKeyword = getParam('keyword');
  if(searchKeyword) {
    $('#header-input').val(searchKeyword);
  }

  // validation

  Validator.useLang('ja');

  $('.js-comment-text').attr("id", "input-comment");
  $('.js-input-text').attr("id", "input-text");

  $('.js-input-star').attr("id", "input-star");
  $('.js-input-name').attr("id", "input-name");
  $('.js-input-email').attr("id", "input-email");
  $('.js-form-submit-profile').attr("id", "profile-form");

  let myRules = {
    'input-comment': 'min:1|max:1000',
    'input-text': 'min:1|max:1000',
    'input-star': 'min:1',
    'input-name': 'min:1|max:30',
    'input-email': 'required|max:255|email',
  };
  let review = false;
  let comment = false;
  $('.js-form-submit-review').on('click', (e) => {
    review = true;
  });
  $('.js-form-submit-comment').on('click', (e) => {
    comment = true;
  });

  $('.js-form-submit').on('click', (e) => {
    $('.c-modal-err').html('');
    let rules = {};
    let valueObj = {};
  $(".js-form-input").each(function() {
    const name = $(this).attr('id');
    let val = $(this).val();
  if ( name === "input-text") {
    val = val.replace(/\s+/g, "").length;
    if(!review) {
      val = 100;
    }
    valueObj[name] = val;
    } else if (name === "input-name") {
      val = val.replace(/\s+/g, "").length;
      valueObj[name] = val;
    } else if ( name === "input-email" ) {
      val = val.replace(/\s+/g, "");
      valueObj[name] = val;
    } else if ( name === "input-comment" ) {
      val = val.replace(/\s+/g, "").length;
      valueObj[name] = val;
      if(!comment) {
        val = 100;
      }
    } else {
      val = val.length;
      if(!review) {
        val = 100;
      }
      valueObj[name] = val;
    }
      valueObj[name] = val;
      if (myRules.hasOwnProperty(name)) {
        rules[name] = myRules[name];
      }
    });
    const validation = new Validator(valueObj, rules, {
      required: '入力必須項目です',
      min: '入力必須項目です',
      max: ':max文字以内で入力してください',
      email: 'メール形式で入力してください' ,
    });
    const fails = validation.fails();
    const errors = validation.errors.all();
    if (fails) {
      e.preventDefault();
      let errKey = "";
      let errValue = "";
      errKey = Object.keys(errors);
      errValue = Object.values(errors);
      errKey.forEach(function(value, i, array) {
        $('#' + errKey[i] + '-err').html('<span class="c-err-text c-modal-err">' + errValue[i] + '</span>');
      });
    } else {
      $('.c-err-text .c-modal-err').html('');
      if(isIOS || isSafari) {
        $('.c-modal').append('<div class="now-loading">Now Loading...</div>')
      } else {
        $('.c-modal').append('<div id="submit-loading" class="loading"></div>');
      }
    };
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

  // サイドバーの挙動
  $('.l-header-barmenu').on('click', function() {
    $('.l-sidebar').toggleClass('activeside');
    $('.l-sidebar-item-text').stop().fadeToggle(150);
    $('.bg-whitegray').toggleClass('activeside');
  });
  // バックエンドで作成したAPIから、通知情報を取得
  let csrf_token= $('#js-getToken').data();
  let cookies = document.cookie; //全てのcookieを取り出して
  let cookiesArray = cookies.split(';'); // ;で分割し配列に
  let notificationLength;
  let apiToken;

  for(var c of cookiesArray){ //一つ一つ取り出して
    var cArray = c.split('='); //さらに=で分割して配列に
    if( cArray[0] == ' api_token'){ // 取り出したいkeyと合致したら
        apiToken = cArray[1];  // [key,value]
    }
  }

  function getNotificationApi() {
    return $.ajax({
      url: '/api/notification',
      type: 'POST',
      datatype: 'json',
      data: {
        _token: csrf_token.name,
        api_token: apiToken,
      },
    }).done(function(data) {
      notificationLength = Object.keys(data).length;
      $('.bell').after('<div class="notification-count">' + notificationLength + '</div>');
      if (notificationLength === 0) {
        $('.bell-list').append('<span>通知がありません</span>');
      } else {
        for (let id of Object.keys(data)) {
          if (data[id]['userId'] === undefined) {
            $('.bell-list').append('<li class="bell-list-item"><a href="/mark/' + id + '/' + data[id]['isbn'] + '/review">' + data[id]['data'] + '</a></li>');
          } else {
            $('.bell-list').append('<li class="bell-list-item"><a href="/mark/' + id + '/' + data[id]['userId'] + '/user">' + data[id]['data'] + '</a></li>');
          }
        }
      }
    }).fail(function() {
      console.log('認証エラーです');
      $('.bell-list').append('<span>認証エラーです。</span>再度<a href="/logout">ログイン</a>してください！');
    });
  }

  getNotificationApi();

  $('.bell-allread').on('click', function() {
    $.ajax({
      url: '/markAsRead',
      type: 'POST',
      datatype: 'json',
      data: {
        _token: csrf_token.name,
      },
    }).done(function(data) {
      $('.notification-count').empty();
      $('.bell-list').empty();
      $(document).ready(function() {
        $('.notification-count').append('0');
        $('.bell-list').append('<span>通知がありません</span>');
      });
    });
  })

  //Pusher通信
  window.Pusher = require('pusher-js');

  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
  });

  let pushNotifications = {
    rankUpChannel: "RankUpEvent",
    registerChannel: "RegisterEvent",
    reviewChannel: "ReviewEvent",
  }

  for (let key in pushNotifications) {
    window.Echo.channel(key)
    .listen(pushNotifications[key], function(data){
      console.log(data);
      if (key == "rankUpChannel") {
        setTimeout(function() {
          return push(data['message']);
        }, 10000)
      } else {
        return push(data['message']);
      }
    });
  }

  //デスクトップ通知
  function push(message){
    Push.create('Book Reviewからのお知らせです', {
      body: message,
      icon: '../favicon.ico',
      timeout: 5000,
      onClick: function () {
          window.focus();
          this.close();
      }
    });
  }
});
