document.addEventListener('DOMContentLoaded', function() {

//=include ../blocks/header/header.js

//=include ../blocks/mobile-menu/mobile-menu.js

;
(function() {
  let lastArticleSelector = 'article.article:last-of-type',
    article = q(lastArticleSelector),
    ftr = q('.ftr'),
    parallaxElements = qa('.with-parallax'),
    imagesWithAlt = qa('figure > img[alt^="Источник"]'),
    loadmore = true,
    url = siteUrl + '/wp-admin/admin-ajax.php',
    showError = function(text, btn) {
      btn && btn.classList.remove('loading');
      errorPopup.openPopup();
      console.warn(text);
    };

  console.log(imagesWithAlt);

  imagesWithAlt.forEach(function(img) {
    img.insertAdjacentHTML('afterend', '<figcaption>' + img.alt + '</figcaption>');
  });

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

;
(function() {
  errorPopup = new Popup('.error-popup', {
    closeButtons: '.error-popup__close'
  });
})();


;thanksPopup = new Popup('.thanks-popup', {
  closeButtons: '.thanks-popup__close'
});

;
(function() {
  searchPopup = new Popup('.search-popup', {
    openButtons: '.hdr__search',
    closeButtons: '.search-popup__close'
  });
  
  // searchPopup.openPopup();

})();

//=include ../blocks/footer/footer.js

});