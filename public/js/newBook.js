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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/api.js":
/*!*****************************!*\
  !*** ./resources/js/api.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

var rakutenUrl = $('#js-getPath').data();
var csrf_token = $('#js-getToken').data();
var rakutenId = $('#js-getId').data();
var base = $('#js-getUrl').data();
var baseUrl = base.name;
var getBooksCount = 30;
var reviewCountArray;
var apiRequestCount = 0;

exports.getBooksApiByCategory = function (booksGenreId, category) {
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: booksGenreId,
      hits: 15,
      page: 1,
      sort: 'sales'
    }
  }).done(function (data) {
    apiRequestCount++;
    $.each(data.Items, function (i, item) {
      $('.' + category).append("<li><a href=\"".concat(baseUrl + '/' + item.Item.isbn + '/detail', "\"><img class=\"slick-img\" alt=\"\" src=\"").concat(item.Item.mediumImageUrl, "\" /><p class=\"slick-title\">").concat(substr(item.Item.title, 15, '...'), "</p></a></li>"));
    });

    if (apiRequestCount === 3) {
      $('.slick').slick({
        settings: 'slick',
        slidesToShow: 5,
        slidesToScroll: 5,
        swipe: true
      });
    }
  }).fail(function (err) {
    console.log(err);
  });
}; // 新刊取得


exports.getBooksApiByNew = function () {
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: '001006',
      hits: getBooksCount,
      page: 1,
      sort: '-releaseDate'
    }
  }).done(function (data) {
    if (data.count == 0) {
      $('.p-newbook__list').append('<p class="p-books-error">これ以上書籍はありません。</p>');
    }

    $.each(data.Items, function (i, item) {
      $('.p-newbook__list').append("<li class=\"p-newbook__item\">\n        <a href=\"".concat(baseUrl + '/' + item.Item.isbn + '/detail', "\" class=\"p-newbook__link\">\n          <img class=\"p-newbook__img\" src=\"").concat(item.Item.mediumImageUrl, "\">\n          <p class=\"p-newbook__title\">").concat(substr(item.Item.title, 35, '...'), "</p>\n        </a>\n      </li>"));
    });
  }).fail(function (err) {
    console.log(err);
  });
}; // キーワードなしでのAPI通信


exports.getBooksApi = function (count, sortName) {
  var deferred = new $.Deferred();
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: '001',
      hits: getBooksCount,
      page: count,
      sort: sortName
    }
  }).done(function (data) {
    if (data.count == 0) {
      $('.p-books-wrapper').append('<p class="p-books-error">これ以上書籍はありません。</p>');
      $(window).off();
    }

    getReviewCountApi(data.Items, count, deferred);
  }).fail(function (err) {
    console.log(err);
  });
  return deferred;
}; //キーワードありでのAPI通信


exports.getBooksOnKeyword = function (count, condition, keyword, sortName) {
  var deferred = new $.Deferred();
  $('.c-section-title').html('<h2 class="c-section-title">検索結果一覧</h2>');

  if (condition === 'title') {
    $.ajax({
      url: rakutenUrl.name,
      type: 'GET',
      datatype: 'json',
      data: {
        applicationId: rakutenId.name,
        booksGenreId: '001',
        hits: getBooksCount,
        page: count,
        title: keyword,
        sort: sortName
      }
    }).done(function (data) {
      getBooksCommon(data, count, deferred);
    }).fail(function (err) {
      console.log(err);
    });
  } else if (condition === 'author') {
    $.ajax({
      url: rakutenUrl.name,
      type: 'GET',
      datatype: 'json',
      data: {
        applicationId: rakutenId.name,
        booksGenreId: '001',
        hits: getBooksCount,
        page: count,
        author: keyword
      }
    }).done(function (data) {
      getBooksCommon(data, count, deferred);
    }).fail(function (err) {
      console.log(err);
    });
  } else if (condition === 'publisher') {
    $.ajax({
      url: rakutenUrl.name,
      type: 'GET',
      datatype: 'json',
      data: {
        applicationId: rakutenId.name,
        booksGenreId: '001',
        hits: getBooksCount,
        page: count,
        publisherName: keyword
      }
    }).done(function (data) {
      getBooksCommon(data, count, deferred);
    }).fail(function (err) {
      console.log(err);
    });
  }

  return deferred;
}; // getBooksOnKeyword関数の処理の共通化


function getBooksCommon(data, count, deferred) {
  if (data.hits == 0) {
    $('.p-books-wrapper').append("<p class=\"p-books-error c-err-card is-long\">\u691C\u7D22\u7D50\u679C\u306F0\u4EF6\u3067\u3059\u3002</p>");
    $(window).off();
  } else {
    getReviewCountApi(data.Items, count, deferred);

    if (data.hits < 30) {
      $('.p-books-wrapper').append("<p class=\"p-books-error\">\u3053\u308C\u4EE5\u4E0A\u66F8\u7C4D\u306F\u3042\u308A\u307E\u305B\u3093\u3002</p>");
      $(window).off();
    }
  }
} // バックエンドで作成したAPIから、レビュー件数を取得


function getReviewCountApi(Items, count, deferred) {
  return $.ajax({
    url: '/api/reviewCount',
    type: 'POST',
    datatype: 'json',
    data: {
      _token: csrf_token.name,
      books: Items
    }
  }).done(function (data) {
    reviewCountArray = data;
    getStarCountApi(Items, count, deferred);
  });
} // バックエンドで作成したAPIから、平均評価を取得


function getStarCountApi(Items, count, deferred) {
  return $.ajax({
    url: '/api/starCount',
    type: 'POST',
    datatype: 'json',
    data: {
      _token: csrf_token.name,
      books: Items
    }
  }).done(function (data) {
    $.each(Items, function (i, item) {
      $('.p-books-lists').append("<li class=\"p-books-list\"><a href=\"".concat(baseUrl + '/' + item.Item.isbn + '/detail', "\" class=\"p-books-link\"><div\n      class=\"p-books-img\"><img src=\"").concat(item.Item.mediumImageUrl, "\" alt=\"\"></div><div class=\"p-books-data\"><p class=\"p-books-ttl\">").concat(substr(item.Item.title, 35, '...'), "</p><p class=\"p-books-author\">\u8457\u8005\uFF1A").concat(substr(item.Item.author, 20, '...'), "</p><p class=\"p-books-publish\">\u51FA\u7248\u793E\uFF1A").concat(substr(item.Item.publisherName, 20, '...'), "</p></div><div class=\"p-books-info\"><div class=\"c-evaluation\"><div class=\"c-evaluation-stars\"><p class=\"c-evaluation-txt\">\u5E73\u5747\u8A55\u4FA1</p><div class=\"c-evaluation-star\" data-count=\"").concat(data[item.Item.isbn], "\"></div></div></div><p class=\"p-books-review\">\u30EC\u30D3\u30E5\u30FC\u4EF6\u6570\uFF1A<span>").concat(reviewCountArray[item.Item.isbn], "</span>\u4EF6</p></div></a></li>"));
    });
    addAvarageStar(count);
    return deferred.resolve();
  });
} //APIから取得した書籍情報に対して、平均評価の星を追加


function addAvarageStar(count) {
  $('.c-evaluation-star').slice((count - 1) * getBooksCount, count * getBooksCount).each(function () {
    var evaluationNumber = $(this).data('count');
    var remainingEvaluationNumber = 5 - evaluationNumber;

    if (evaluationNumber == 0) {
      $(this).append('<p class="c-evaluation-nothing">なし</p>');
    } else {
      for (var _i = 0; _i < evaluationNumber; _i++) {
        $(this).append('<span class="c-evaluation-star-icon is-star-colord">★</span>');
      }

      for (var _i2 = 0; _i2 < remainingEvaluationNumber; _i2++) {
        $(this).append('<span class="c-evaluation-star-icon">★</span>');
      }
    }
  });
} // 文字丸める処理


function substr(text, len, truncation) {
  if (truncation === undefined) {
    truncation = '';
  }

  var text_array = text.split('');
  var count = 0;
  var str = '';

  for (i = 0; i < text_array.length; i++) {
    var n = escape(text_array[i]);
    if (n.length < 4) count++;else count += 2;

    if (count > len) {
      return str + truncation;
    }

    str += text.charAt(i);
  }

  return text;
}

/***/ }),

/***/ "./resources/js/newBook.js":
/*!*********************************!*\
  !*** ./resources/js/newBook.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

$(function () {
  var api = __webpack_require__(/*! ./api */ "./resources/js/api.js");

  api.getBooksApiByNew();
});

/***/ }),

/***/ 6:
/*!***************************************!*\
  !*** multi ./resources/js/newBook.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/sataketatsuya/Desktop/heroku/Laravel74/resources/js/newBook.js */"./resources/js/newBook.js");


/***/ })

/******/ });