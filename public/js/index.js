!function(t){var e={};function o(n){if(e[n])return e[n].exports;var a=e[n]={i:n,l:!1,exports:{}};return t[n].call(a.exports,a,a.exports,o),a.l=!0,a.exports}o.m=t,o.c=e,o.d=function(t,e,n){o.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},o.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)o.d(n,a,function(e){return t[e]}.bind(null,a));return n},o.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return o.d(e,"a",e),e},o.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},o.p="/",o(o.s=59)}({1:function(t,e){var o,n=$("#js-getPath").data(),a=$("#js-getToken").data(),s=$("#js-getId").data(),c=$("#js-getUrl").data().name,r=0;function l(t,e,o){0==t.hits?($(".p-books-wrapper").append('<p class="p-books-error c-err-card is-long">検索結果は0件です。</p>'),$(window).off()):(p(t.Items,e,o),t.hits<30&&($(".p-books-wrapper").append('<p class="p-books-error">これ以上書籍はありません。</p>'),$(window).off()))}function p(t,e,n){return $.ajax({url:"/api/reviewCount",type:"POST",datatype:"json",data:{_token:a.name,books:t}}).done((function(s){o=s,function(t,e,n){$.ajax({url:"/api/starCount",type:"POST",datatype:"json",data:{_token:a.name,books:t}}).done((function(a){return $.each(t,(function(t,e){$(".p-books-lists").append('<li class="p-books-list"><a href="'.concat(c+"/"+e.Item.isbn+"/detail",'" class="p-books-link"><div\n      class="p-books-img"><img src="').concat(e.Item.mediumImageUrl,'" alt=""></div><div class="p-books-data"><p class="p-books-ttl">').concat(u(e.Item.title,35,"..."),'</p><p class="p-books-author">著者：').concat(u(e.Item.author,20,"..."),'</p><p class="p-books-publish">出版社：').concat(u(e.Item.publisherName,20,"..."),'</p></div><div class="p-books-info"><div class="c-evaluation"><div class="c-evaluation-stars"><p class="c-evaluation-txt">平均評価</p><div class="c-evaluation-star" data-count="').concat(a[e.Item.isbn],'"></div></div></div><p class="p-books-review">レビュー件数：<span>').concat(o[e.Item.isbn],"</span>件</p></div></a></li>"))})),function(t){$(".c-evaluation-star").slice(30*(t-1),30*t).each((function(){var t=$(this).data("count"),e=5-t;if(0==t)$(this).append('<p class="c-evaluation-nothing">なし</p>');else{for(var o=0;o<t;o++)$(this).append('<span class="c-evaluation-star-icon is-star-colord">★</span>');for(var n=0;n<e;n++)$(this).append('<span class="c-evaluation-star-icon">★</span>')}}))}(e),n.resolve()}))}(t,e,n)}))}function u(t,e,o){void 0===o&&(o="");var n=t.split(""),a=0,s="";for(i=0;i<n.length;i++){if(escape(n[i]).length<4?a++:a+=2,a>e)return s+o;s+=t.charAt(i)}return t}e.getBooksApiByCategory=function(t,e){$.ajax({url:n.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:t,hits:15,page:1,sort:"sales"}}).done((function(t){r++,$.each(t.Items,(function(t,o){$("."+e).append('<li><a href="'.concat(c+"/"+o.Item.isbn+"/detail",'"><img class="slick-img" alt="" src="').concat(o.Item.mediumImageUrl,'" /><p class="slick-title">').concat(u(o.Item.title,15,"..."),"</p></a></li>"))})),3===r&&$(".slick").slick({settings:"slick",slidesToShow:5,slidesToScroll:5,swipe:!0})})).fail((function(t){console.log(t)}))},e.getBooksApiByNew=function(){$.ajax({url:n.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001006",hits:30,page:1,sort:"-releaseDate"}}).done((function(t){0==t.count&&$(".p-newbook__list").append('<p class="p-books-error">これ以上書籍はありません。</p>'),$.each(t.Items,(function(t,e){$(".p-newbook__list").append('<li class="p-newbook__item">\n        <a href="'.concat(c+"/"+e.Item.isbn+"/detail",'" class="p-newbook__link">\n          <img class="p-newbook__img" src="').concat(e.Item.mediumImageUrl,'">\n          <p class="p-newbook__title">').concat(u(e.Item.title,35,"..."),"</p>\n        </a>\n      </li>"))}))})).fail((function(t){console.log(t)}))},e.getBooksApi=function(t,e){var o=new $.Deferred;return $.ajax({url:n.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:t,sort:e}}).done((function(e){0==e.count&&($(".p-books-wrapper").append('<p class="p-books-error">これ以上書籍はありません。</p>'),$(window).off()),p(e.Items,t,o)})).fail((function(t){console.log(t)})),o},e.getBooksOnKeyword=function(t,e,o,a){var i=new $.Deferred;return $(".c-section-title").html('<h2 class="c-section-title">検索結果一覧</h2>'),"title"===e?$.ajax({url:n.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:t,title:o,sort:a}}).done((function(e){l(e,t,i)})).fail((function(t){console.log(t)})):"author"===e?$.ajax({url:n.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:t,author:o}}).done((function(e){l(e,t,i)})).fail((function(t){console.log(t)})):"publisher"===e&&$.ajax({url:n.name,type:"GET",datatype:"json",data:{applicationId:s.name,booksGenreId:"001",hits:30,page:t,publisherName:o}}).done((function(e){l(e,t,i)})).fail((function(t){console.log(t)})),i}},59:function(t,e,o){t.exports=o(60)},60:function(t,e,o){$((function(){var t=o(1);$(".p-books-contents-caption-text").each((function(){var t=$(this).text().length,e=$(this).text().substr(0,"6");"6"<t?$(this).html(e+"...").css({visibility:"visible"}):"6">=t&&$(this).css({visibility:"visible"})})),t.getBooksApiByCategory("001005005","program"),t.getBooksApiByCategory("001006009","self"),t.getBooksApiByCategory("001006023","business")}))}});