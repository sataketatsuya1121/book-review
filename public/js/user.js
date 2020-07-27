/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/user.js":
/*!******************************!*\
  !*** ./resources/js/user.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $(document).on('click', '.js-star-icon', function () {
    $(this).parent().children('.js-star-icon').removeClass('is-star-colord');
    var starIndex = $(this).index();

    for (var i = 0; i <= starIndex; i++) {
      $(this).parent().children(".js-star-icon:eq(".concat(i, ")")).addClass('is-star-colord');
    }

    $('.starIndexInput').val(starIndex + 1);
  });
  $('.is-edit').click(function () {
    var url = $(this).data('url');
    var content = $(this).data('content');
    var evaluation = $(this).data('evaluation');
    $('form').attr('action', url);
    $('.p-detail-modal-detail-textbox').val(content);
    $('.starIndexInput').val(evaluation);
    $('.p-user-modal-evaluation-star').each(function () {
      var normalStar = 5 - evaluation;
      var starList = '';

      for (var i = 0; i < evaluation; i++) {
        starList += '<span class="c-evaluation-star-icon is-form-star js-star-icon is-star-colord">★</span>';
      }

      for (var i = 0; i < normalStar; i++) {
        starList += '<span class="c-evaluation-star-icon is-form-star js-star-icon">★</span>';
      }

      $(this).html(starList);
    });
  });
  $('.p-user-review-btn-delete').click(function () {
    var url = $(this).data('url');
    $('form').attr('action', url);
  });
  $('.p-user-stock-btn-delete').click(function () {
    var url = $(this).data('url');
    $('form').attr('action', url);
  });
  $(document).ready(function () {
    $('.c-evaluation-star').each(function () {
      var _int = $(this).data('count');

      var bint = 5 - _int;

      for (var i = 0; i < _int; i++) {
        $(this).append('<span class="c-evaluation-star-icon a">★</span>');
        $('.a').addClass('is-star-colord');
      }

      for (var i = 0; i < bint; i++) {
        $(this).append('<span class="c-evaluation-star-icon">★</span>');
      }
    });
  });
  $('input[type=file]').on('change', function () {
    var target = $(this).attr('id');
    var targetValue = $(this).val().replace(/^.*\\/, "");
    $('.js-' + target).text(targetValue);
  });
  var active = 'js-active';
  var activeBtn = 'js-active-btn-user';
  $('[data-tab-trigger]').on('click', function () {
    $('.js-active-btn-user').removeClass(activeBtn);
    $(this).addClass(activeBtn);
    var target = $(this).data('tab-trigger');
    $('.js-active').removeClass(active);
    $('[data-tab-target = ' + target + ']').addClass(active).hide().fadeIn(500);
  });
  var achievement = $('#js-archievement').data();

  if (achievement.name === 1) {
    $('.p-user-status-title').append("<div class=\"p-user-status-title-gold-img p-user-is-img\"></div>");
    $('.p-user-status-title').append("<p class=\"p-user-status-title-gold p-user-is-title\">\u30B4\u30FC\u30EB\u30C9\u30E9\u30F3\u30AF</p>");
  } else if (achievement.name === 2) {
    $('.p-user-status-title').append("<div class=\"p-user-status-title-silver-img p-user-is-img\"></div>");
    $('.p-user-status-title').append("<p class=\"p-user-status-title-silver p-user-is-title\">\u30B7\u30EB\u30D0\u30FC\u30E9\u30F3\u30AF</p>");
  } else if (achievement.name === 3) {
    $('.p-user-status-title').append("<div class=\"p-user-status-title-bronze-img p-user-is-img\"></div>");
    $('.p-user-status-title').append("<p class=\"p-user-status-title-bronze p-user-is-title\">\u30D6\u30ED\u30F3\u30BA\u30E9\u30F3\u30AF</p>");
  } else {
    $('.p-user-status-title').append("<div class=\"p-user-status-title-regular-img p-user-is-img\"></div>");
    $('.p-user-status-title').append("<p class=\"p-user-status-title-regular p-user-is-title\">\u30EC\u30AE\u30E5\u30E9\u30FC\u30E9\u30F3\u30AF</p>");
  }

  var csrf_token = $('#js-get-token').data();
  var img_normalicon = $('#js-get-img-normal').data();
  var img_goodicon = $('#js-get-img-good').data();
  var favoriteState = true;
  $('.favorites-flag').each(function () {
    var _this = this;

    $(this).on('click', function (e) {
      var favoriteId = $(_this).find('.favoriteId').data('favoriteid');

      if ($(_this).hasClass('done') && favoriteState) {
        favoriteState = false;
        $.ajax({
          type: 'POST',
          url: '/review/' + favoriteId + '/unFavorite',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            favoriteId: favoriteId
          },
          context: _this
        }).done(function (data) {
          if (data == '404') {
            console.log('404');
          } else {
            $(this).removeClass('done');
            $(this).children('img').attr('src', img_normalicon.name);
            favoriteState = true;
          }
        }).fail(function (msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(_this).hasClass('done') && favoriteState) {
        favoriteState = false;
        $.ajax({
          type: 'POST',
          url: '/review/' + favoriteId + '/favorite',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            favoriteId: favoriteId
          },
          context: _this
        }).done(function (data) {
          if (data == '404') {
            console.log('404');
          } else {
            $(this).addClass('done');
            $(this).children('img').attr('src', img_goodicon.name);
            favoriteState = true;
          }
        }).fail(function (msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  });
});

/***/ }),

/***/ 3:
/*!************************************!*\
  !*** multi ./resources/js/user.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/sataketatsuya/Desktop/heroku/Laravel74/resources/js/user.js */"./resources/js/user.js");


/***/ })

/******/ });