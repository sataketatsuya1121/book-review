!function(n){var t={};function e(a){if(t[a])return t[a].exports;var o=t[a]={i:a,l:!1,exports:{}};return n[a].call(o.exports,o,o.exports,e),o.l=!0,o.exports}e.m=n,e.c=t,e.d=function(n,t,a){e.o(n,t)||Object.defineProperty(n,t,{enumerable:!0,get:a})},e.r=function(n){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})},e.t=function(n,t){if(1&t&&(n=e(n)),8&t)return n;if(4&t&&"object"==typeof n&&n&&n.__esModule)return n;var a=Object.create(null);if(e.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:n}),2&t&&"string"!=typeof n)for(var o in n)e.d(a,o,function(t){return n[t]}.bind(null,o));return a},e.n=function(n){var t=n&&n.__esModule?function(){return n.default}:function(){return n};return e.d(t,"a",t),t},e.o=function(n,t){return Object.prototype.hasOwnProperty.call(n,t)},e.p="/",e(e.s=69)}({0:function(n,t){var e,a=$("#js-getPath").data(),o=$("#js-getToken").data(),s=$("#js-getId").data(),r=$("#js-getUrl").data().name,c=1;t.getBooksApiByCategory=function(n,t){$.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:n,hits:15,page:1,sort:"sales"}}).done((function(n){c++,$.each(n.Items,(function(n,e){$("."+t).append('<li><a href="'.concat(r+"/"+e.Item.isbn+"/detail",'"><img class="slick-img" alt="" src="').concat(e.Item.mediumImageUrl,'" /><p class="slick-title">').concat(u(e.Item.title,15,"..."),"</p></a></li>"))})),4===c&&$(".slick").slick({settings:"slick",slidesToShow:5,slidesToScroll:5,swipe:!0})})).fail((function(n){console.log(n)}))};var l=["zero","first","second","third","fourth","fifth"];function p(n,t,e){0==n.hits?($(".p-books-wrapper").append('<p class="p-books-error c-err-card is-long">検索結果は0件です。</p>'),$(window).off()):(d(n.Items,t,e),n.hits<30&&($(".p-books-wrapper").append('<p class="p-books-error">これ以上書籍はありません。</p>'),$(window).off()))}function d(n,t,a){return $.ajax({url:"/api/reviewCount",type:"POST",datatype:"json",data:{_token:o.name,books:n}}).done((function(i){e=i,function(n,t,a){$.ajax({url:"/api/starCount",type:"POST",datatype:"json",data:{_token:o.name,books:n}}).done((function(o){return $.each(n,(function(n,t){$(".p-books-lists").append('<li class="p-books-list"><a href="'.concat(r+"/"+t.Item.isbn+"/detail",'" class="p-books-link"><div\n      class="p-books-img"><img src="').concat(t.Item.mediumImageUrl,'" alt=""></div><div class="p-books-data"><p class="p-books-ttl">').concat(u(t.Item.title,35,"..."),'</p><p class="p-books-author">著者：').concat(u(t.Item.author,20,"..."),'</p><p class="p-books-publish">出版社：').concat(u(t.Item.publisherName,20,"..."),'</p></div><div class="p-books-info"><div class="c-evaluation"><div class="c-evaluation-stars"><p class="c-evaluation-txt">平均評価</p><div class="c-evaluation-star" data-count="').concat(o[t.Item.isbn],'"></div></div></div><p class="p-books-review">レビュー件数：<span>').concat(e[t.Item.isbn],"</span>件</p></div></a></li>"))})),function(n){$(".c-evaluation-star").slice(30*(n-1),30*n).each((function(){var n=$(this).data("count"),t=5-n;if(0==n)$(this).append('<p class="c-evaluation-nothing">なし</p>');else{for(var e=0;e<n;e++)$(this).append('<span class="c-evaluation-star-icon is-star-colord">★</span>');for(var a=0;a<t;a++)$(this).append('<span class="c-evaluation-star-icon">★</span>')}}))}(t),a.resolve()}))}(n,t,a)}))}function u(n,t,e){void 0===e&&(e="");var a=n.split(""),o=0,s="";for(i=0;i<a.length;i++){if(escape(a[i]).length<4?o++:o+=2,o>t)return s+e;s+=n.charAt(i)}return n}t.getBooksApiByRanking=function(n){$.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:n,hits:30,page:1,sort:"sales"}}).done((function(n){$(".p-ranking-order").html(""),$(".p-ranking-book__list").html(""),$.each(n.Items,(function(n,t){if(n<=4)return n++,$(".p-ranking-order").append('<div class="p-ranking-order__item">\n          <a href="'.concat(r+"/"+t.Item.isbn+"/detail",'" class="p-ranking-order__link is-').concat(l[n],'">\n            <img alt="" src="').concat(t.Item.largeImageUrl,'">\n          </a>\n          <p class="p-ranking-order__rank">').concat(n,"</p>\n        </div>")),!0;$(".p-ranking-book__list").append('<li class="p-ranking-book__item">\n        <a href="'.concat(r+"/"+t.Item.isbn+"/detail",'" class="p-ranking-book__link">\n          <img alt="" src="').concat(t.Item.largeImageUrl,'">\n          <span>').concat(u(t.Item.title,35,"..."),"</span>\n        </a>\n      </li>"))}))})).fail((function(n){console.log(n)}))},t.getBooksApiByNew=function(){$.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001006",hits:30,page:1,sort:"-releaseDate"}}).done((function(n){0==n.count&&$(".p-newbook__list").append('<p class="p-books-error">これ以上書籍はありません。</p>'),$.each(n.Items,(function(n,t){$(".p-newbook__list").append('<li class="p-newbook__item">\n        <a href="'.concat(r+"/"+t.Item.isbn+"/detail",'" class="p-newbook__link">\n          <img class="p-newbook__img" src="').concat(t.Item.mediumImageUrl,'">\n          <p class="p-newbook__title">').concat(u(t.Item.title,35,"..."),"</p>\n        </a>\n      </li>"))}))})).fail((function(n){console.log(n)}))},t.getBooksApi=function(n,t){var e=new $.Deferred;return $.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:n,sort:t}}).done((function(t){0==t.count&&($(".p-books-wrapper").append('<p class="p-books-error">これ以上書籍はありません。</p>'),$(window).off()),d(t.Items,n,e)})).fail((function(n){console.log(n)})),e},t.getBooksOnKeyword=function(n,t,e,o){var i=new $.Deferred;return $(".c-section-title").html('<h2 class="c-section-title">検索結果一覧</h2>'),"title"===t?$.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:n,title:e,sort:o}}).done((function(t){p(t,n,i)})).fail((function(n){console.log(n)})):"author"===t?$.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:n,author:e}}).done((function(t){p(t,n,i)})).fail((function(n){console.log(n)})):"publisher"===t&&$.ajax({url:a.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:n,publisherName:e}}).done((function(t){p(t,n,i)})).fail((function(n){console.log(n)})),i}},69:function(n,t,e){n.exports=e(70)},70:function(n,t,e){$((function(){e(0).getBooksApiByNew()}))}});