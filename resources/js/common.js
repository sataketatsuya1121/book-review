// 読み込みアニメーション表示・非表示
exports.loading = function(loadingState) {
  if(loadingState) {
    $('#loading').remove();
    loadingState = false;
  } else {
    $('.p-books-wrapper').append('<div id="loading"></div>');
    loadingState = true;
  }
  return loadingState;
}

//urlのパラメータを取得
exports.getParam = function(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
