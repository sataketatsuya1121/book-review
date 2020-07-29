$(function() {

  const api = require('./api');

  let searchQuery = $('#js-search-query').data('name');
  let condition = $('#js-condition').data('name');
  let keyword = $('#js-keyword').data('name');
  let page = $('#js-page').data('name');
  let booksGenreId = '001';

  showBooksApiBrowse();

  // もっとみるボタン・カテゴリ検索
  function showBooksApiBrowse(sortName = 'sales') {
    if (searchQuery === 'program') {
      booksGenreId = '001005005';
    } else if (searchQuery === 'self') {
      booksGenreId = '001006009';
    } else if (searchQuery === 'business') {
      booksGenreId = '001006023';
    }
    showSearchedBooksApiBrowse(sortName);
  }

  // ワードorカテゴリ検索
  function showSearchedBooksApiBrowse(sortName) {
    if (keyword) {
      $('input[name="condition"]').prop("checked", false);
      api.getBooksOnKeyword(page, condition, keyword, sortName, booksGenreId);
    } else {
      api.getBooksApi(page, sortName, booksGenreId);
    }
  }

  // 新刊ボタンをクリック時にソート
  $('.js-release').on('click', function() {
    sortName = '-releaseDate';
    showBooksApiBrowse(sortName);
  });
  // 売り上げボタンをクリック時にソート
  $('.js-sales').on('click', function() {
    sortName = 'sales';
    showBooksApiBrowse(sortName);
  });

  showPaginateButton(page);

  function showPaginateButton(page) {
    let url = $('#js-getBaseUrl').data('name');
    let pace = '&';
    if (keyword) {
      url = url + '?condition=' + condition + '&keyword=' + keyword;
    } else {
      pace = '?';
    }

    // pagination < > をnext prevへ置換
    $('.pagination .page-link').first().text("prev");
    $('.pagination .page-link').last().text("next");

    if (page > 1) {
      $('.p-result-paginate__list').append(`<li class="page-item"><a class="page-link" href="${url + pace}page=${page - 1}" rel="previous" lavel="aria-label="pagination.previous">prev</a></li>`);
    }

    if (page < '6') {
      for (let i = 1; i < 11; i++) {
        $('.p-result-paginate__list').append(`<li class="page-item"><a class="page-link" href="${url + pace}page=${i}" data-num="${i}"><span>${i}</span></a></li>`);
      }
    } else {
      for (let i = page -5; i < page + 5; i++) {
        $('.p-result-paginate__list').append(`<li class="page-item"><a class="page-link" href="${url + pace}page=${i}" data-num="${i}"><span">${i}</span></a></li>`);
      };
    }

    $('[data-num = ' + page + ']').addClass('active');
    $('.p-result-paginate__list').append(`<li class="page-item"><a class="page-link" href="${url + pace}page=${page + 1}" rel="next" aria-label="pagination.next">next</a></li>`);
  }

  $('[data-tab-trigger]').click(function(){
    var activeBtn = 'js-active-tabbtn'
    var target = $(this).data('tab-trigger');

    $('#result-line').removeClass().addClass('#result-line').addClass(target);
    $('.js-active-tabbtn').removeClass(activeBtn);
		$('[data-tab-trigger = ' + target + ']').addClass(activeBtn);
  });
});
