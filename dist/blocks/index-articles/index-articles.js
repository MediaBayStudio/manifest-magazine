;
(function() {
  let articlesSections = qa('.articles-sect'),
    initial = true,
    showError = function(text, btn) {
      btn.classList.remove('loading');
      errorPopup.openPopup();
      console.warn(text);
    },
    setArticlesQuantity = function(articles, articlesBlock) {
      if (articlesBlock.wasLoadmore || articles.length < 5) {
        return;
      }
      let isMobile = media('(max-width: 1023.98px)'),
        articlesQuantity = isMobile ? 4 : 6,
        childs = [articles[articles.length - 1], articles[articles.length - 2]],
        action = '';

      if (isMobile) {
        if (articles.length > articlesQuantity) {
          action = 'add';
        }
      } else {
        if (articles.length > articlesQuantity) {
          action = 'add';
        } else {
          action = 'remove';
        }
      }

      if (action) {
        for (let i = 0, len = childs.length; i < len; i++) {
          if (childs[i]) {
            childs[i].classList[action]('hide');
          }
        }
      }

      console.log('setArticlesQuantity');
    };

  for (let i = 0, len = articlesSections.length; i < len; i++) {
    let loadmoreButton = q('.articles-sect__loadmore', articlesSections[i]),
      articlesBlock = q('.articles-sect__articles', articlesSections[i]),
      existsArticles = qa('.article-card', articlesBlock[i]),
      visibleImages = qa('.article-card:not(.hide) .article-card__img'),
      articlesMasonryBlock;

    if (media('(min-width:767.98px)')) {
      articlesMasonryBlock = new Masonry(articlesBlock, {
        itemSelector: '.article-card',
        columnWidth: '.article-card',
        gutter: '.gutter-size',
      });
      visibleImages.forEach(function(img) {
        img.addEventListener('load', function() {
          articlesMasonryBlock.layout();
        });
      });
    }

    articlesBlock.wasLoadmore = false;

    setArticlesQuantity(existsArticles, articlesBlock);
    windowFuncs.resize.push(setArticlesQuantity.bind(null, existsArticles, articlesBlock));

    loadmoreButton.addEventListener('click', function() {
      loadmoreButton.classList.add('loading');

      let url = siteUrl + '/wp-admin/admin-ajax.php',
        data = 'action=loadmore&post_type=' + loadmoreButton.dataset.postType;

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
            response = JSON.parse(response);
            articlesBlock.wasLoadmore = true;
            loadmoreButton.classList.remove('loading');
            articlesBlock.insertAdjacentHTML('beforeend', response);

            let hiddenArticles = qa('.article-card.hide', articlesBlock),
              hiddenImages = qa('.article-card.hide .article-card__img'),
              articlesQuantity = media('(max-width: 1023.98px)') ? 4 : 6;

            if (articlesMasonryBlock) {
              // imagesLoaded(articlesBlock).on('progress', function() {
              //   articlesMasonryBlock.layout();
              // });
            }

            for (let i = 0; i < articlesQuantity; i++) {
              if (hiddenArticles[i]) {
                hiddenArticles[i].classList.remove('hide');
                if (articlesMasonryBlock) {
                  hiddenImages[i].addEventListener('load', function() {
                    articlesMasonryBlock.layout();
                  });
                  articlesMasonryBlock.appended(hiddenArticles[i]);
                }
              }
            }

            // articlesBlock.style.maxHeight = articlesBlock.scrollHeight + 'px';
          } catch (err) {
            showError(err, loadmoreButton);
          }
        })
        .catch(function(err) {
          showError(err, loadmoreButton);
        });
    });
  }
})();