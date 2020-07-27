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

/***/ "./resources/js/detail.js":
/*!********************************!*\
  !*** ./resources/js/detail.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var csrf_token = $('#js-get-token').data();
  var img_normalicon = $('#js-get-img-normal').data();
  var img_goodicon = $('#js-get-img-good').data();
  var stock_readbook = $('#js-get-stock').data();
  $(document).ready(function () {
    $('.c-evaluation-star').each(function () {
      var evaluation = $(this).data('count');
      var normalStar = 5 - evaluation;
      var starList = '';

      for (var i = 0; i < evaluation; i++) {
        starList += '<span class="c-evaluation-star-icon js-star-icon is-star-colord">★</span>';
      }

      for (var i = 0; i < normalStar; i++) {
        starList += '<span class="c-evaluation-star-icon js-star-icon">★</span>';
      }

      $(this).append(starList);
    });
  });
  var likeState = true;
  $('.likes-flag').each(function () {
    var _this = this;

    $(this).on('click', function (e) {
      var reviewId = $(_this).find('.reviewId').data('reviewid');
      var likesCount = parseInt($(_this).nextAll('.likes-count').text());

      if ($(_this).hasClass('done') && likeState) {
        likeState = false;
        $.ajax({
          type: 'POST',
          url: '/review/' + reviewId + '/unLike',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            reviewId: reviewId
          },
          context: _this
        }).done(function (data) {
          if (data == '404') {
            console.log('404');
          } else {
            $(this).removeClass('done');
            $(this).nextAll('.likes-count').text(likesCount -= 1);
            $(this).children('img').attr('src', img_normalicon.name);
            likeState = true;
          }
        }).fail(function (msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(_this).hasClass('done') && likeState) {
        likeState = false;
        $.ajax({
          type: 'POST',
          url: '/review/' + reviewId + '/like',
          dataType: 'json',
          data: {
            _token: csrf_token.name,
            reviewId: reviewId
          },
          context: _this
        }).done(function (data) {
          if (data == '404') {
            console.log('404');
          } else {
            $(this).addClass('done');
            $(this).nextAll('.likes-count').text(likesCount += 1);
            $(this).children('img').attr('src', img_goodicon.name);
            likeState = true;
          }
        }).fail(function (msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  }); //ソート機能のcss付け替え

  $('.p-detail-columns-reviews-sorts p').on('click', function () {
    $('.p-detail-columns-reviews-sorts p').removeClass('sort-active');
    $(this).addClass('sort-active');
  });
  $('.c-modal-close').on('click', function () {
    $('.js-form-input').val(null);
    $('.js-star-icon').removeClass('is-star-colord');
  }); //ストック機能

  var stockState = true;
  var isbn = stock_readbook.name;
  $('.stock').on('click', function () {
    if ($(this).hasClass('is-remove') && stockState) {
      stockState = false;
      $.ajax({
        type: 'DELETE',
        url: '/review/' + isbn + '/unstock',
        dataType: 'json',
        data: {
          _token: csrf_token.name,
          isbn: isbn
        },
        context: this
      }).done(function (data) {
        $(this).removeClass('is-remove');
        $(this).text('読みたい本リストに追加');
        stockState = true;
      }).fail(function (msg) {
        console.log('NG' + msg.responseText);
      });
    } else if (!$(this).hasClass('is-remove') && stockState) {
      stockState = false;
      $.ajax({
        type: 'POST',
        url: '/review/' + isbn + '/stock',
        dataType: 'json',
        data: {
          _token: csrf_token.name,
          isbn: isbn
        },
        context: this
      }).done(function (data) {
        $(this).addClass('is-remove');
        $(this).text('リストから削除');
        stockState = true;
      }).fail(function (msg) {
        console.log('NG' + msg.responseText);
      });
    }
  }); //レビューにコメントする機能

  $('.comment-post-button').on('click', function () {
    var reviewId = $(this).data('reviewid');
    $('.comment-review-id').val(reviewId);
  });
  $('.comments').hide();
  $('.js-comment-button').each(function (index) {
    var i = index;
    $(this).attr('id', 'js-' + i + '-comment-button');
    var button = '#js-' + i + '-comment-button';
    $(button).on('click', function () {
      var comments = '.js-' + i + '-comments';
      $(comments).slideToggle();
    });
  });
  $('.comments').each(function (index) {
    var i = index;
    $(this).attr('class', 'js-' + i + '-comments');
    var comments = 'js-' + i + '-comments';
  });
  $('.is-view').on('click', function () {
    $(this).toggleClass('active');

    if ($(this).hasClass('active')) {
      var text = $(this).data('text-clicked');
    } else {
      var text = $(this).data('text-default');
    }

    $(this).html(text);
  });
});

/***/ }),

/***/ 3:
/*!**************************************!*\
  !*** multi ./resources/js/detail.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/sataketatsuya/Desktop/heroku/Laravel74/resources/js/detail.js */"./resources/js/detail.js");


/***/ })

/******/ });