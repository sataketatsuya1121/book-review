$(function() {
  const api = require('./api');

  let booksGenreId = '001';
  api.getBooksApiByRanking(booksGenreId);
  $('.p-ranking-category__link').click(function() {
    let category = $(this).data('category');
    if (category === 'program') {
      booksGenreId = '001005005';
    } else if (category === 'self' ) {
      booksGenreId = '001006009';
    } else if (category === 'business') {
      booksGenreId = '001006023';
    } else {
      booksGenreId = '001';
    }
    api.getBooksApiByRanking(booksGenreId);
  });
});
