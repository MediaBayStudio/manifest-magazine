;
(function() {
  let lastArticleSelector = 'article.article:last-of-type',
    article = q(lastArticleSelector),
    ftr = q('.ftr'),
    parallaxElements = qa('.with-parallax'),
    loadmore = true,
    url = siteUrl + '/wp-admin/admin-ajax.php',
    showError = function(text, btn) {
      btn && btn.classList.remove('loading');
      errorPopup.openPopup();
      console.warn(text);
    };


  if (article) {
    window.addEventListener('scroll', function() {
      if (loadmore && pageYOffset >= ftr.offsetTop - ftr.offsetHeight * 2) {

        loadmore = false;

        let excludeArticles = qa('article.article', article.parentElement, true),
          exclideArticlesString = excludeArticles
          .map(exclideArticle => exclideArticle.getAttribute('data-post-id'))
          .join(' '),
          data = [
            'action=create_article',
            'next_article=1',
            'exists_post=' + q(lastArticleSelector).getAttribute('data-post-id'),
            'exclude_posts=' + exclideArticlesString,
            'parent_category=' + article.getAttribute('data-parent-category')
          ].join('&');

        console.log(data);

        fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: data
          })
          .then(function(response) {
            if (response.ok) {
              return response.text();
            } else {
              showError('Ошибка ' + response.status + ' (' + response.statusText + ')', btn);
              return '';
            }
          })
          .then(function(response) {
            try {
              // response = JSON.parse(response);
              ftr.insertAdjacentHTML('beforebegin', response);
              loadmore = true;
            } catch (err) {
              showError(err);
            }
          })
          .catch(function(err) {
            showError(err);
          }); // end fetch
      }
    });
  }

  parallaxElements.forEach(function(parallaxBlock) {
    let figure = q('figure', parallaxBlock),
      image = q('img', parallaxBlock),
      setHeight = function() {
        figure.style.height = image.offsetHeight / 2 + 'px';
      };
      windowFuncs.resize.push(setHeight);
      setHeight();
  });
})();