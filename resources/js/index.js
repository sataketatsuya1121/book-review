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
});
