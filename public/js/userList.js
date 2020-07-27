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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/userList.js":
/*!**********************************!*\
  !*** ./resources/js/userList.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  // タブ切り替え
  $('[data-tab-trigger]').click(function () {
    var activeBtn = 'active-tabbtn';
    var activeContents = 'active-tabcontents';
    var target = $(this).data('tab-trigger');
    $('#line').removeClass().addClass('#line').addClass(target);
    $('.active-tabbtn').removeClass(activeBtn);
    $('[data-tab-trigger = ' + target + ']').addClass(activeBtn);
    $('.active-tabcontents').removeClass(activeContents);
    $('[data-tab-target = ' + target + ']').addClass(activeContents).hide().fadeIn(300);
  });
  var csrf_token = $('#js-get-token').data();
  var img_normalicon = $('#js-get-img-normal').data();
  var favoriteState = true;
  $('.favorites-flag').each(function () {
    var _this = this;

    $(this).on('click', function (e) {
      var favoriteId = $(_this).find('.favoriteId').data('favoriteid');

      if ($(_this).hasClass('is-remove') && favoriteState) {
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
            $(this).removeClass('is-remove');
            $(this).children('p').html('お気に入り登録'); // $('.p-userlist-glance-item-link-star').attr('src', '');

            favoriteState = true;
          }
        }).fail(function (msg) {
          console.log('NG' + msg.responseText);
        });
      } else if (!$(_this).hasClass('is-remove') && favoriteState) {
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
            $(this).addClass('is-remove');
            $(this).children('p').html('お気に入り登録解除'); // $('.p-userlist-glance-item-link-star').attr('src', img_normalicon.name);

            favoriteState = true;
          }
        }).fail(function (msg) {
          console.log('NG' + msg.responseText);
        });
      }
    });
  }); //絞り込み年数

  var time = new Date();
  var year = time.getFullYear();

  for (var i = year; i >= 2015; i--) {
    $('#year').append('<option value="' + i + '">' + i + '</option>');
  }

  for (var i = 1; i <= 12; i++) {
    $('#month').append('<option value="' + i + '">' + i + '</option>');
  }
});

/***/ }),

/***/ 4:
/*!****************************************!*\
  !*** multi ./resources/js/userList.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/sataketatsuya/Desktop/heroku/Laravel74/resources/js/userList.js */"./resources/js/userList.js");


/***/ })

/******/ });