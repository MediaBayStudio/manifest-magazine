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
      visibleImages = qa('.loadmore-block > [class*="-card"]:not(.hide) img', loadmoreSections[i]),
      defaultCardsClass = loadmoreButton.getAttribute('data-cards-class'),
      masonry = loadmoreButton.getAttribute('data-grid-masonry'),
      masonryMediaQuery = loadmoreButton.getAttribute('data-masonry-media-query'),
      postsCountMobile = loadmoreButton.getAttribute('data-posts-count-mobile'),
      postsCountDesktop = loadmoreButton.getAttribute('data-posts-count-desktop'),
      mobileMediaQuery = loadmoreButton.getAttribute('data-mobile-media-query'),
      postsCount = loadmoreButton.getAttribute('data-posts-count'),
      orderby = loadmoreButton.getAttribute('data-orderby'),
      order = loadmoreButton.getAttribute('data-order'),
      metaKey = loadmoreButton.getAttribute('data-meta-key'),
      offset = loadmoreButton.getAttribute('data-offset'),
      articlesMasonryBlock;

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

      let posts = qa('.loadmore-block > [class*="-card"]', loadmoreSections[i], true),
        url = siteUrl + '/wp-admin/admin-ajax.php',
        data = 'action=loadmore&post_type=' + loadmoreButton.getAttribute('data-post-type') +
        '&numberposts=' + loadmoreButton.getAttribute('data-numberposts'),
        excludedPosts = '&exclude=',
        excludePostsAttr = loadmoreButton.getAttribute('data-posts-exclude');

      for (let i = 0, len = posts.length; i < len; i++) {
        let postId = posts[i].getAttribute('data-post-id');
        if (postId) {
          excludedPosts += postId + ' ';
        }
      }

      excludedPosts = excludedPosts.slice(0, -1);

      if (excludePostsAttr) {
        excludedPosts += ' ' + excludePostsAttr;
      }

      data += excludedPosts;

      // console.log(excludedPosts);

      // if (offset) {
      //   offset = +offset + posts.length;
      // } else {
      //   offset = posts.length;
      // }

      // offset = posts.length;

      // console.log('offset', offset);
      // console.log('posts.length', posts.length);

      // data += '&offset=' + offset;

      if (orderby) {
        data += '&orderby=' + orderby;
      }

      if (order) {
        data += '&order=' + order;
      }

      if (metaKey) {
        data += '&meta_key=' + metaKey;
      }

      if (defaultCardsClass) {
        data += '&default_class=' + defaultCardsClass;
      }

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

            let posts = qa('article', loadmoreBlock),
              hiddenArticles = qa('[class*="-card"].hide', loadmoreBlock),
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

            console.log('posts.length', posts.length);
            console.log('postsCount', postsCount);

            if (posts.length >= postsCount || excludePostsAttr && posts.length + 6 >= postsCount) {
              loadmoreButton.classList.add('hide');
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