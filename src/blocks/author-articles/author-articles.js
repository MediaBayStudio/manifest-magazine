;
(function() {
  let categoriesBlockSelector = '.author-articles-sect__categories',
    slidesSelector = '.author-article-card',
    articlesSlider = qa('.author-articles-slider'),
    categoriesBlock = q(categoriesBlockSelector),
    categoriesBlockTitle = q('.author-articles-sect__current-category', categoriesBlock);

  if (categoriesBlock) {
    categoriesBlock.addEventListener('click', function(e) {
      let target = e.target;

      if (target.classList.contains('author-articles-sect__current-category')) {
        categoriesBlock.classList.toggle('active');
      } else if (target.classList.contains('author-articles-sect__category')) {
        let text = categoriesBlockTitle.textContent,
          id = categoriesBlockTitle.getAttribute('data-id');

        categoriesBlockTitle.textContent = target.textContent;
        target.textContent = text;

        categoriesBlockTitle.setAttribute('data-id', target.getAttribute('data-id'))
        target.setAttribute('data-id', id);

        categoriesBlock.classList.toggle('active');
      }

      console.log(target); 
    });

    body.addEventListener('click', function(e) {
      let target = e.target;

      if (!target.closest(categoriesBlockSelector)) {
        categoriesBlock.classList.remove('active');
      }
    });
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