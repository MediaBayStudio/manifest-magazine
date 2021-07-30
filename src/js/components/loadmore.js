initLoadmore = function() {
  let loadmoreSections = qa('.loadmore-sect'),
    showError = function(text, btn) {
      btn.classList.remove('loading');
      errorPopup.openPopup();
      console.warn(text);
    },
    setArticlesQuantity = function(posts, loadmoreBlock, mobileMediaQuery, postsCountMobile, postsCountDesktop) {
      if (loadmoreBlock.wasLoadmore || posts.length < postsCountDesktop - 1) {
        return;
      }
      let isMobile = media(mobileMediaQuery),
        articlesQuantity = isMobile ? postsCountMobile : postsCountDesktop,
        childs = [],
        i = postsCountDesktop - postsCountMobile,
        j = 1,
        action = '';

      // Элементы, которые будут скрыты
      while (i) {
        childs[childs.length] = posts[posts.length - j];
        j++;
        i--;
      }

      if (isMobile) {
        if (posts.length > articlesQuantity) {
          action = 'add';
        }
      } else {
        if (posts.length > articlesQuantity) {
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
    };


  for (let i = 0, len = loadmoreSections.length; i < len; i++) {
    let loadmoreButton = q('.loadmore-btn', loadmoreSections[i]),
      loadmoreBlock = q('.loadmore-block', loadmoreSections[i]),
      existsArticles = qa('.loadmore-block > *:not(.gutter-size)', loadmoreSections[i]),
      visibleImages = qa('[class*="-card"]:not(.hide) img', loadmoreBlock),
      defaultCardsClass = loadmoreButton.getAttribute('data-cards-class'),
      masonry = loadmoreButton.getAttribute('data-grid-masonry'),
      masonryMediaQuery = loadmoreButton.getAttribute('data-masonry-media-query'),
      postsCountMobile = loadmoreButton.getAttribute('data-posts-count-mobile'),
      postsCountDesktop = loadmoreButton.getAttribute('data-posts-count-desktop'),
      mobileMediaQuery = loadmoreButton.getAttribute('data-mobile-media-query'),
      articlesMasonryBlock;

      // console.log(loadmoreSections[i]);
      // console.log('postsCountMobile', postsCountMobile);
      // console.log('postsCountDesktop', postsCountDesktop);
      // console.log('----------');

    // console.log(loadmoreButton);
    // console.log(loadmoreBlock);
    // console.log(existsArticles[0].className);

    if (masonry === 'true' && media(masonryMediaQuery)) {
      articlesMasonryBlock = new Masonry(loadmoreBlock, {
        itemSelector: '.' + existsArticles[0].className,
        columnWidth: '.' + existsArticles[0].className,
        gutter: '.gutter-size',
      });

      visibleImages.forEach(function(img) {
        img.addEventListener('load', function() {
          articlesMasonryBlock.layout();
        });
      });
    }

    loadmoreBlock.wasLoadmore = false;

    setArticlesQuantity(existsArticles, loadmoreBlock, mobileMediaQuery, postsCountMobile, postsCountDesktop);
    windowFuncs.resize.push(setArticlesQuantity.bind(null, existsArticles, loadmoreBlock, mobileMediaQuery, postsCountMobile, postsCountDesktop));

    loadmoreButton.addEventListener('click', function() {
      loadmoreButton.classList.add('loading');

      let url = siteUrl + '/wp-admin/admin-ajax.php',
        data = 'action=loadmore&post_type=' + loadmoreButton.getAttribute('data-post-type') + '&numberposts=' + loadmoreButton.getAttribute('data-numberposts');

      if (defaultCardsClass) {
        data += '&default_class=' + defaultCardsClass;
      }

      console.log(defaultCardsClass);
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
            response = JSON.parse(response);
            loadmoreBlock.wasLoadmore = true;
            loadmoreButton.classList.remove('loading');
            loadmoreBlock.insertAdjacentHTML('beforeend', response);

            let hiddenArticles = qa('[class*="-card"].hide', loadmoreBlock),
              hiddenImages = qa('[class*="-card"].hide img', loadmoreBlock),
              articlesQuantity = media(mobileMediaQuery) ? postsCountMobile : postsCountDesktop;

            for (let i = 0; i < articlesQuantity; i++) {
              if (hiddenArticles[i]) {
                hiddenArticles[i].classList.remove('hide');
                if (masonry === 'true' && articlesMasonryBlock) {
                  hiddenImages[i].addEventListener('load', function() {
                    articlesMasonryBlock.layout();
                  });
                  articlesMasonryBlock.appended(hiddenArticles[i]);
                }
              }
            }
          } catch (err) {
            showError(err, loadmoreButton);
          }
        })
        .catch(function(err) {
          showError(err, loadmoreButton);
        });
    });
  }
};

initLoadmore();