$(function() {

    // 実装が完了してない箇所・バグ

    // URLは変更するがページネーションできてない
    // キーワード検索したときのページネーションができてない。URLのkeywordパラメータが消える
    // キーワード検索した時にキーワードがフォームに表示されたままではない
    // クリックしたページネーション番号が常に左にきている。
    // ページネーションの<と>マークの挙動。disableになっていない
    // ソート機能を引き継いだままページネーションができてない

    let rakutenUrl = $('#js-getPath').data();
    let rakutenId = $('#js-getId').data();
    let searchQuery = $('#js-search-query').data();
    let condition = $('#js-condition').data();
    let keyword = $('#js-keyword').data();
    let page = $('#js-page').data();
    let baseUrl = $('#js-getBaseUrl').data();
    let getBooksCount = 20;
    let href = location.href;

    console.log(searchQuery);
    console.log(condition);
    console.log(keyword);
    console.log(page);

    showBooksApiBrowse();

    // 書籍をブラウザに表示
    function showBooksApiBrowse(sortName = 'sales') {
      // トップページでプログラミングのもっとみるを押した時
      if (searchQuery.name === 'プログラミング') {
        getBooksApiByCategory('001005005', 'program', 'プログラミング', page, sortName);

      // トップページで自己啓発のもっとみるを押した時
      } else if (searchQuery.name === '自己啓発') {
        getBooksApiByCategory('001006009', 'self', '自己啓発', page, sortName);

      // トップページでビジネスマナーのもっとみるを押した時
      } else if (searchQuery.name === 'ビジネスマナー') {
        getBooksApiByCategory('001006023', 'business', 'ビジネスマナー', page, sortName);

      // トップページでレビューのある本のもっとみるを押した時
      } else if (!searchQuery.name && !condition.name) {
        $('.p-result-sort').empty();
        $('.p-books-contents-head').html('レビューのある本');
        $('.p-result-paginate').addClass('p-result-disactive');
        $('ul').removeClass('p-result-disactive');
        $('div').removeClass('p-result-disactive');

      // ヘッダーのキーワードなしで検索した時
      } else if (condition.name && !keyword.name) {
        console.log('キーワードなしの検索です')
        getBooksApi(page, sortName);

      // ヘッダーのキーワードありで検索した時
      } else if (condition.name && keyword.name) {
        console.log('キーワードありの検索です')
        getBooksApiOnkeyword(page, condition.name, keyword.name, sortName);

      // それ以外の時のエラーハンドリング
      } else {
        $('.p-books-contents-head').html('もう一度検索し直してください');
      }
    }

    // カテゴリ検索
    function getBooksApiByCategory(booksGenreId, category, contentHead, page = 1, sortName) {
      $.ajax({
        url: rakutenUrl.name,
        type: 'GET',
        datatype: 'json',
        data: {
          applicationId: rakutenId.name,
          booksGenreId: booksGenreId,
          hits: getBooksCount,
          page: page,
          sort: sortName,
        },
      }).done(function(data) {
        $('.p-books-contents-head').html(contentHead);
        $.each(data.Items, function(i, item) {
          $('.p-result-' + category).append(`<li><a class="p-result-list" href="${baseUrl.name}/review/${item.Item.isbn}/detail"><img class="p-result-image" src="${item.Item.mediumImageUrl}"><p class="p-result-title">${substr(item.Item.title, 15, '...')}</p></a></li>`);
        });
      }).fail(function(err) {
        console.log(err);
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

      // キーワードなしでのAPI通信
    function getBooksApi(page = 1, sortName) {
      let deferred = new $.Deferred();
      $.ajax({
        url: rakutenUrl.name,
        type: 'GET',
        datatype: 'json',
        data: {
          applicationId: rakutenId.name,
          booksGenreId: '001',
          hits: getBooksCount,
          page: page,
          sort: sortName,
        },
      }).done(function(data) {
        console.log(data);
        if(data.count === 0) {
          $('.p-books-contents-head').html('<p class="p-books-error">ヒットした書籍がありません。</p>');
        } else {
          $('.p-books-contents-head').html(`タイトルの検索結果です`);
          $.each(data.Items, function(i, item) {
            $('.p-result-keyword').append(`<li><a class="p-result-list" href="${baseUrl.name}/review/${item.Item.isbn}/detail"><img class="p-result-image" src="${item.Item.mediumImageUrl}"><p class="p-result-title">${substr(item.Item.title, 15, '...')}</p></a></li>`);
          });
        }
      }).fail(function(err) {
        console.log(err);
      });
      return deferred;
    }

    //キーワードありでのAPI通信
    function getBooksApiOnkeyword(page = 1, condition, keyword, sortName) {
      let deferred = new $.Deferred();
      $('.c-section-title').html('<h2 class="c-section-title">検索結果一覧</h2>');
      if(condition === 'title') {
        $.ajax({
          url: rakutenUrl.name,
          type: 'GET',
          datatype: 'json',
          data: {
            applicationId: rakutenId.name,
            booksGenreId: '001',
            hits: getBooksCount,
            page: page,
            title: keyword,
            sort: sortName,
          },
        }).done(function(data) {
          getBooksCommon(data, page, deferred);
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
            page: page,
            author: keyword,
          },
        }).done(function(data) {
          getBooksCommon(data, page, deferred);
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
            page: page,
            publisherName: keyword,
          },
        }).done(function(data) {
          getBooksCommon(data, page, deferred);
        }).fail(function(err) {
          console.log(err);
        });
      }
      return deferred;
    }

    // getBooksOnKeyword関数の処理の共通化
    function getBooksCommon(data, page, deferred) {
      if(data.hits == 0) {
        $('.p-books-contents-head').html('<p class="p-books-error">ヒットした書籍がありません。</p>');
      } else {
        $('.p-books-contents-head').html(`${keyword.name}の検索`);
        $.each(data.Items, function(i, item) {
          $('.p-result-keyword').append(`<li><a class="p-result-list" href="${baseUrl.name}/review/${item.Item.isbn}/detail"><img class="p-result-image" src="${item.Item.mediumImageUrl}"><p class="p-result-title">${substr(item.Item.title, 15, '...')}</p></a></li>`);
        });
      }
    }

    showPaginateButton();

    function showPaginateButton() {
      // if (page.name !== '') {
        $('.p-result-paginate-list').append(`<li class="page-item"><a class="page-link" href="${href.split('&')[0]}&page=${page.name - 1}" rel="previous" lavel="aria-label="pagination.previous"><</a></li>`);
      // } else {
      //   $('.p-result-paginate-list').append(`<li class="page-item" aria-disabled="true" aria-label="pagination.previous"><a href="${href.split('&')[0]}&page=${page.name - 1}"><span class="page-link" aria-hidden="true"><</span></a></li>`);
      // }
      for (let i = page.name + 1; i < page.name + 5; i++) {
        $('.p-result-paginate-list').append(`<li class="page-item"><a class="page-link" href="${href.split('&')[0]}&page=${i}"><span class="page-link">${i}</span></a></li>`);
      }
      $('.p-result-paginate-list').append(`<li class="page-item"><a class="page-link" href="${href.split('&')[0]}&page=${page.name - 4}" rel="next" aria-label="pagination.next">></a></li>`);
    }

    // 新刊ボタンをクリック時にソート
    $('.p-result-sort-release').on('click', function() {
      console.log('release clicked!!');
      sortName = '-releaseDate';
      $('.p-result').empty();
      $(document).each(function() {
        showBooksApiBrowse(sortName);
      })
    });

    // 売り上げボタンをクリック時にソート
    $('.p-result-sort-sales').on('click', function() {
      console.log('sales clicked!!');
      sortName = 'sales';
      $('.p-result').empty();
      $(document).each(function() {
        showBooksApiBrowse(sortName);
      })
    });

  });

  {/* <li class="page-item" aria-disabled="true" aria-label="pagination.previous"><a href=""><span class="page-link" aria-hidden="true"><</span></a></li>
  <li class="page-item active"><span class="page-link">1</span></li>
  <li class="page-item"><a class="page-link" href="http://localhost:4444/results?page=2">2</a></li>
  <li class="page-item"><a class="page-link" href="http://localhost:4444/results?page=2">3</a></li>
  <li class="page-item"><a class="page-link" href="http://localhost:4444/results?page=2">4</a></li>
  <li class="page-item"><a class="page-link" href="http://localhost:4444/results?page=2">5</a></li>
  <li class="page-item"><a class="page-link" href="http://localhost:4444/results?page=2" rel="next" aria-label="pagination.next">></a></li> */}
