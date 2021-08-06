;
(function() {
  let categoriesBlockSelector = '.author-articles-sect__categories',
    slidesSelector = '.author-article-card',
    articlesSlider = qa('.author-articles-slider'),
    categoriesBlock = q(categoriesBlockSelector),
    categoriesBlockTitle = q('.author-articles-sect__current-category', categoriesBlock),
    sect = q('.author-articles-sect.authors-page'),
    showError = function(text, btn) {
      btn.classList.remove('loading');
      errorPopup.openPopup();
      console.warn(text);
    };

  if (categoriesBlock) {
    categoriesBlock.addEventListener('click', function(e) {
      let target = e.target;

      if (target.classList.contains('author-articles-sect__current-category')) {
        categoriesBlock.classList.toggle('active');
      } else if (target.classList.contains('author-articles-sect__category')) {
        let loadmoreBtn = q('.author-articles-sect__loadmore'),
          text = categoriesBlockTitle.textContent,
          id = categoriesBlockTitle.getAttribute('data-id'),
          targetId = target.getAttribute('data-id'),
          url = siteUrl + '/wp-admin/admin-ajax.php',
          data = 'action=loadmore&numberposts=10&category=' + targetId + '&default_class=author-article-card';

        categoriesBlockTitle.textContent = target.textContent;
        target.textContent = text;

        categoriesBlockTitle.setAttribute('data-id', targetId);
        target.setAttribute('data-id', id);

        categoriesBlock.classList.toggle('active');

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

              let impl = document.implementation.createHTMLDocument().body;
              impl.insertAdjacentHTML('beforeend', response);

              let articles = qa('article', impl),
                articlesLength = articles.length,
                categoryCount = q('div[data-posts-count]', impl).getAttribute('data-posts-count'),
                sections = qa('.author-articles-sect__articles'),
                excludePosts = '';

              sections[0].innerHTML = '';
              sections[1].innerHTML = '';

              loadmoreBtn.classList.toggle('hide', articlesLength >= categoryCount);

              for (let i = 0; i < articlesLength; i++) {
                if (i < 6) {
                  sections[0].insertAdjacentElement('beforeend', articles[i]);
                  excludePosts += articles[i].getAttribute('data-post-id') + ' ';
                } else {
                  sections[1].insertAdjacentElement('beforeend', articles[i]);
                }
              }

              excludePosts = excludePosts.slice(0, -1);

              loadmoreBtn.setAttribute('data-category', targetId);
              loadmoreBtn.setAttribute('data-posts-count', categoryCount);
              loadmoreBtn.setAttribute('data-posts-exclude', excludePosts);

              console.log(categoryCount);
              console.log(impl);
            } catch (err) {
              showError(err, loadmoreBtn);
            }
          })
          .catch(function(err) {
            showError(err, loadmoreBtn);
          });

      }
    });

    body.addEventListener('click', function(e) {
      let target = e.target;

      if (!target.closest(categoriesBlockSelector)) {
        categoriesBlock.classList.remove('active');
      }
    });
  }

  if (sect) {
    let cards = qa('.author-article-card', sect),
      loadmoreBtn = q('.author-articles-sect .loadmore-btn'),
      excludedPosts = '';

    for (let i = 0, len = cards.length; i < len; i++) {
      if (i > 0) {
        excludedPosts += ' ';
      }
      excludedPosts += cards[i].getAttribute('data-post-id');
    }

    loadmoreBtn.setAttribute('data-posts-exclude', excludedPosts);
  }

  for (let i = 0, len = articlesSlider.length; i < len; i++) {
    let $articlesSlider = $(articlesSlider[i]),
      slides = qa(slidesSelector, articlesSlider[i]),
      buildSlider = function() {
        if (media('(max-width:575.98px)')) {
          if (SLIDER.hasSlickClass($articlesSlider)) {
            SLIDER.unslick($articlesSlider);
          }
        } else {
          if (SLIDER.hasSlickClass($articlesSlider)) {
            // слайдер уже создан
            return;
          }
          if (slides.length && slides.length > 2) {
            $articlesSlider.slick({
              slidesToShow: 2,
              slide: slidesSelector,
              draggable: false,
              appendArrows: $('.author-articles-slider__nav', $articlesSlider),
              prevArrow: SLIDER.createArrow('author-articles-slider__prev', SLIDER.arrowSvg),
              nextArrow: SLIDER.createArrow('author-articles-slider__next', SLIDER.arrowSvg),
              infinite: false
            });
          }
        }
      };

    buildSlider();
    windowFuncs.resize.push(buildSlider);
  }
})();