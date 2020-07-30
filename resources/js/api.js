let rakutenUrl = $('#js-getPath').data();
let csrf_token= $('#js-getToken').data();
let rakutenId =$('#js-getId').data();
let base =$('#js-getUrl').data();
let baseUrl = base.name;
let getBooksCount = 30;
let reviewCountArray;
let apiRequestCount = 1;
let categoryArray;

exports.selectCategory = function(booksGenreId) {
  $.ajax({
    url: 'https://app.rakuten.co.jp/services/api/BooksGenre/Search/20121128',
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: booksGenreId,
    },
  }).done(function(data) {
    if (booksGenreId == '001') {
      $.each(data.children, function(i, item) {
        $('.l-header-modal__select-content').append(`<p class="l-header-modal__category" data-category="${item.child.booksGenreId}">${item.child.booksGenreName}</p>`);
      });
    } else {
      categoryArray = '';
      $('.l-header-modal__head').html(data.current.booksGenreName);
      $.each(data.children, function(i, item) {
        categoryArray += `<a href="${baseUrl + '/' + item.child.booksGenreId + '/results'}" class="l-header-modal__category">${item.child.booksGenreName}</a>`;
      });
      $('.l-header-modal__detail-content').html(categoryArray);
    }
  }).fail(function(err) {
    console.log(err);
  });
}

exports.getBooksApiByCategory = function(booksGenreId, category) {
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: booksGenreId,
      hits: 15,
      page: 1,
      sort: 'sales',
    },
  }).done(function(data) {
    apiRequestCount++;
    $.each(data.Items, function(i, item) {
      $('.' + category).append(`<li><a href="${baseUrl + '/' + item.Item.isbn + '/detail'}"><img class="slick__img" alt="" src="${item.Item.mediumImageUrl}" /><p class="slick__title">${substr(item.Item.title, 15, '...')}</p></a></li>`);
    });
    if(apiRequestCount === 4) {
      $('.slick').slick({
        settings: 'slick',
        slidesToShow: 5,
        slidesToScroll: 5,
        swipe: true,
      });
    }
  }).fail(function(err) {
    console.log(err);
  });
}

// ランキング取得
let rank = ['zero', 'first', 'second', 'third', 'fourth', 'fifth'];
exports.getBooksApiByRanking = function(booksGenreId) {
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: booksGenreId,
      hits: getBooksCount,
      page: 1,
      sort: 'sales',
    },
  }).done(function(data) {
    $('.p-ranking-order').html('');
    $('.p-ranking-book__list').html('');
    $.each(data.Items, function(i, item) {
      if(i<=4) {
        i++;
        $('.p-ranking-order').append(`<div class="p-ranking-order__item">
          <a href="${baseUrl + '/' + item.Item.isbn + '/detail'}" class="p-ranking-order__link is-${rank[i]}">
            <img alt="" src="${item.Item.largeImageUrl}">
          </a>
          <p class="p-ranking-order__rank">${i}</p>
        </div>`);
        return true;
      }
      $('.p-ranking-book__list').append(`<li class="p-ranking-book__item">
        <a href="${baseUrl + '/' + item.Item.isbn + '/detail'}" class="p-ranking-book__link">
          <img alt="" src="${item.Item.largeImageUrl}">
          <span>${substr(item.Item.title, 35, '...')}</span>
        </a>
      </li>`);
    });
  }).fail(function(err) {
    console.log(err);
  });
}

// 新刊取得
exports.getBooksApiByNew = function() {
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: '001006',
      hits: getBooksCount,
      page: 1,
      sort: '-releaseDate',
    },
  }).done(function(data) {
    if(data.count == 0) {
      $('.p-newbook__list').append('<p class="p-books-error">これ以上書籍はありません。</p>');
    }
    $.each(data.Items, function(i, item) {
      $('.p-newbook__list').append(`<li class="p-newbook__item">
        <a href="${baseUrl + '/' + item.Item.isbn + '/detail'}" class="p-newbook__link">
          <img class="p-newbook__img" src="${item.Item.mediumImageUrl}">
          <p class="p-newbook__title">${substr(item.Item.title, 35, '...')}</p>
        </a>
      </li>`);
    });
  }).fail(function(err) {
    console.log(err);
  });
}

// キーワードなしでのAPI通信
exports.getBooksApi = function(count, sortName, booksGenreId = '001') {
  let deferred = new $.Deferred();
  $.ajax({
    url: rakutenUrl.name,
    type: 'GET',
    datatype: 'json',
    data: {
      applicationId: rakutenId.name,
      booksGenreId: booksGenreId,
      hits: getBooksCount,
      page: count,
      sort: sortName,
    },
  }).done(function(data) {
    if(data.count == 0) {
      $('.p-books-wrapper').append('<p class="p-books-error">これ以上書籍はありません。</p>');
      $(window).off();
    }
    getReviewCountApi(data.Items, count, deferred);
  }).fail(function(err) {
    console.log(err);
  });
  return deferred;
}

//キーワードありでのAPI通信
exports.getBooksOnKeyword = function(count, condition, keyword, sortName, booksGenreId = '001') {
  $('input[value="' + condition +'"]').prop("checked", true);
  let deferred = new $.Deferred();
  $('.c-section__title').html('<h2 class="c-section__title">検索結果一覧</h2>');
  if(condition === 'title') {
    $.ajax({
      url: rakutenUrl.name,
      type: 'GET',
      datatype: 'json',
      data: {
        applicationId: rakutenId.name,
        booksGenreId: booksGenreId,
        hits: getBooksCount,
        page: count,
        title: keyword,
        sort: sortName,
      },
    }).done(function(data) {
      getBooksCommon(data, count, deferred);
    }).fail(function(err) {
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
        author: keyword,
      },
    }).done(function(data) {
      getBooksCommon(data, count, deferred);
    }).fail(function(err) {
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
        publisherName: keyword,
      },
    }).done(function(data) {
      getBooksCommon(data, count, deferred);
    }).fail(function(err) {
      console.log(err);
    });
  }
  return deferred;
}

// getBooksOnKeyword関数の処理の共通化
function getBooksCommon(data, count, deferred) {
  if(data.hits == 0) {
    $('.p-books-lists').html(`<p class="p-books-error c-err-card is-long">検索結果は0件です。</p>`);
    $(window).off();
  } else {
    getReviewCountApi(data.Items, count, deferred);
    if(data.hits < 30) {
      $('.p-books-lists').append(`<p class="p-books-error">これ以上書籍はありません。</p>`);
      $(window).off();
    }
  }
}

// バックエンドで作成したAPIから、レビュー件数を取得
function getReviewCountApi(Items, count, deferred) {
  return $.ajax({
    url: '/api/reviewCount',
    type: 'POST',
    datatype: 'json',
    data: {
      _token: csrf_token.name,
      books: Items,
    },
  }).done(function(data) {
    reviewCountArray = data;
    getStarCountApi(Items, count, deferred);
  });
}

// バックエンドで作成したAPIから、平均評価を取得
function getStarCountApi(Items, count, deferred) {
  return $.ajax({
    url: '/api/starCount',
    type: 'POST',
    datatype: 'json',
    data: {
      _token: csrf_token.name,
      books: Items,
    },
  }).done(function(data) {
    $('.p-books-lists').html('');
    $.each(Items, function(i, item) {
      $('.p-books-lists').append(`<li class="">
        <a href="${baseUrl + '/' + item.Item.isbn + '/detail'}" class="p-result__link">
          <img src="${item.Item.mediumImageUrl}" alt="" class="p-result__img">
          <p class="p-result__title">${substr(item.Item.title, 35, '...')}</p>
          <p class="p-result__review">レビュー件数：<span>${reviewCountArray[item.Item.isbn]}</span>件</p>
          <div class="c-evaluation">
            <p class="c-evaluation__text">評価</p>
            <div class="c-evaluation__star" data-count="${data[item.Item.isbn]}"></div>
          </div>
        </a>
      </li>`);
    });
    addAvarageStar();
    return deferred.resolve();
  });
}

//APIから取得した書籍情報に対して、平均評価の星を追加
function addAvarageStar(count = 1) {
  $('.c-evaluation__star').slice((count - 1) * getBooksCount, count * getBooksCount).each(function() {
    let evaluationNumber = $(this).data('count');
    let remainingEvaluationNumber = 5 - evaluationNumber;
    if(evaluationNumber == 0) {
      $(this).append('<p class="c-evaluation__text">なし</p>');
    } else {
      for(let i = 0; i < evaluationNumber; i++) {
        $(this).append('<span class="c-evaluation__star-icon is-star-colord">★</span>');
      }
      for(let i = 0; i < remainingEvaluationNumber; i++) {
        $(this).append('<span class="c-evaluation__star-icon">★</span>');
      }
    }
  });
}

// 文字丸める処理
function substr(text, len, truncation) {
  if(truncation === undefined) { truncation = ''; }
  let text_array = text.split('');
  let count = 0;
  let str = '';
  for (i = 0; i < text_array.length; i++) {
    let n = escape(text_array[i]);
    if(n.length < 4) count++;
    else count += 2;
    if(count > len) {
      return str + truncation;
    }
    str += text.charAt(i);
  }
  return text;
}
