document.addEventListener('DOMContentLoaded', function() {

//=include ../blocks/header/header.js

//=include ../blocks/mobile-menu/mobile-menu.js

;(function() {
  let slider = q('.index-hero-sect'),
    progress = q('.index-hero-sect__progress ', slider),
    progressCurrentNumber = q('.slider-progress__current-number', progress),
    progressBg = q('.slider-progress__background', progress),
    slidesSelector = '.index-hero-sect__slide',
    slides = qa(slidesSelector, slider),
    $slider =  $(slider),
    isSmallImg = slider.classList.contains('small-img'),
    buildHeroSlider = function() {
      if (SLIDER.hasSlickClass($slider)) {
        // слайдер уже создан
        return;
      }
      if (slides.length && slides.length > 1) {
        $slider.slick({
          slide: slidesSelector,
          arrows: false,
          infinite: false,
          fade: isSmallImg,
          // appendArrows: $('.index-hero-sect__arrows'),
          // prevArrow: SLIDER.createArrow('index-hero-sect__prev', arrowSvg),
          // nextArrow: SLIDER.createArrow('index-hero-sect__next', arrowSvg),
          draggable: false,
          mobileFirst: true,
          responsive: [{
            breakpoint: 1023.98,
            settings: {
              arrows: true,
              prevArrow: SLIDER.createArrow('index-hero-sect__prev', SLIDER.arrowSvg),
              nextArrow: SLIDER.createArrow('index-hero-sect__next', SLIDER.arrowSvg)
            }
          }]
        });
      }
    };

    $slider.on('init reInit beforeChange', function(e, slick, currentSlide, nextSlide) {
      if (currentSlide !== nextSlide) {
        percent = 1 + nextSlide;
      } else if (currentSlide === undefined) {
        currentSlide = currentSlide || 0;
        percent = 1 + currentSlide;
      }

      if (percent) {
        progressBg.style.width = percent / slides.length * 100 + '%';
      }

      if (nextSlide !== undefined) {
        progressCurrentNumber.textContent = '0' + (nextSlide + 1);
      }

      // progress.classList.toggle('last-slide', nextSlide + 1 === slides.length);
    });

    buildHeroSlider();
    windowFuncs.resize.push(buildHeroSlider);

})();

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
      articlesMasonryBlock;

    if (media('(min-width:767.98px)')) {
      imagesLoaded(articlesBlock).on('progress', function() {
        articlesMasonryBlock = new Masonry(articlesBlock, {
          itemSelector: '.article-card',
          columnWidth: '.article-card',
          gutter: '.gutter-size',
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
              articlesQuantity = media('(max-width: 1023.98px)') ? 4 : 6;

            if (articlesMasonryBlock) {
              imagesLoaded(articlesBlock).on('progress', function() {
                articlesMasonryBlock.layout();
              });
            }

            for (let i = 0; i < articlesQuantity; i++) {
              console.log(i);
              if (hiddenArticles[i]) {
                hiddenArticles[i].classList.remove('hide');
                if (articlesMasonryBlock) {
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

;
(function() {
  errorPopup = new Popup('.error-popup', {
    closeButtons: '.error-popup__close'
  });
})();

//=include ../blocks/thanks-popup/thanks-popup.js

//=include ../blocks/footer/footer.js

});