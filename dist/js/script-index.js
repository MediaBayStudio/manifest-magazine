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
        progressCurrentNumber.textContent = ('0' + (nextSlide + 1)).slice(-2);
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
    };


  for (let i = 0, len = articlesSections.length; i < len; i++) {
    let loadmoreButton = q('.articles-sect__loadmore', articlesSections[i]),
      articlesBlock = q('.articles-sect__articles', articlesSections[i]),
      existsArticles = qa('.article-card', articlesBlock),
      visibleImages = qa('.article-card:not(.hide) .article-card__img', articlesBlock),
      articlesMasonryBlock;

    if (media('(min-width:575.98px)')) {
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
              hiddenImages = qa('.article-card.hide .article-card__img', articlesBlock),
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

;
(function() {
  let articlesSlider = qa('.category-articles-sect__articles'),
    slidesSelector = '.article-card';

  for (let i = 0, len = articlesSlider.length; i < len; i++) {
    let $articlesSlider = $(articlesSlider[i]),
      slides = qa(slidesSelector, articlesSlider[i]),
      buildSlider = function() {
        if (media('(min-width:1023.98px)') && slides.length < 4) {
          if (SLIDER.hasSlickClass($articlesSlider)) {
            SLIDER.unslick($articlesSlider);
          }
          // если ширина экрана больше 1440px и слайдов меньше 7, то слайдера не будет
        } else if (media('(min-width:575.98px)') && slides.length < 3) {
          if (SLIDER.hasSlickClass($articlesSlider)) {
            SLIDER.unslick($articlesSlider);
          }
          // если ширина экрана больше 1440px и слайдов меньше 7, то слайдера не будет
        } else {
          if (SLIDER.hasSlickClass($articlesSlider)) {
            // слайдер уже создан
            return;
          }
          if (slides.length && slides.length > 1) {
            $articlesSlider.slick({
              slide: slidesSelector,
              draggable: false,
              appendArrows: $('.category-articles__nav', $articlesSlider),
              prevArrow: SLIDER.createArrow('category-articles__prev', SLIDER.arrowSvg),
              nextArrow: SLIDER.createArrow('category-articles__next', SLIDER.arrowSvg),
              infinite: false,
              mobileFirst: true,
              responsive: [{
                breakpoint: 575.98,
                settings: {
                  slidesToShow: 2
                }
              }, {
                breakpoint: 1023.98,
                settings: {
                  slidesToShow: 3
                }
              }]
            });
          }
        }
      };

    buildSlider();
    windowFuncs.resize.push(buildSlider);
  }
})();

;
(function() {
  let articlesSlider = qa('.author-articles-slider'),
    slidesSelector = '.author-article-card';

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

//=include ../blocks/index-quote/index-quote.js

//=include ../blocks/index-subscribe/index-subscribe.js

;
(function() {
  errorPopup = new Popup('.error-popup', {
    closeButtons: '.error-popup__close'
  });
})();

//=include ../blocks/thanks-popup/thanks-popup.js

//=include ../blocks/footer/footer.js

});