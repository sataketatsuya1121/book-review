$(function() {
  const api = require('./api');
  let cutfigure = '6';
  let aftertxt = '...';

  $('.p-books-contents-caption-text').each(function() {
    let txtlength = $(this).text().length;
    let texttrim = $(this).text().substr(0,(cutfigure));

    if(cutfigure < txtlength) {
      $(this).html(texttrim + aftertxt).css({visibility:'visible'});
    } else if(cutfigure >= txtlength) {
      $(this).css({visibility:'visible'});
    }
  });

  api.getBooksApiByCategory('001005005', 'program');
  api.getBooksApiByCategory('001006009', 'self');
  api.getBooksApiByCategory('001006023', 'business');
  //APIから取得した書籍情報に対して、平均評価の星を追加
	function addAvarageStar() {
    $('.c-evaluation-star').slice((pageCount - 1) * getBooksCount ,pageCount * getBooksCount).each(function() {
			let evaluationNumber = $(this).data('count');
			let remainingEvaluationNumber = 5 - evaluationNumber;
			if(evaluationNumber == 0) {
				$(this).append('<p class="c-evaluation-nothing">なし</p>');
			} else {
				for(let i = 0; i < evaluationNumber; i++) {
					$(this).append('<span class="c-evaluation-star-icon is-star-colord">★</span>');
				}
				for(let i = 0; i < remainingEvaluationNumber; i++) {
					$(this).append('<span class="c-evaluation-star-icon">★</span>');
				}
			}
    });
  }
});
