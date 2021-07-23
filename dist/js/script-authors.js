document.addEventListener('DOMContentLoaded', function() {

//=include ../blocks/header/header.js

//=include ../blocks/mobile-menu/mobile-menu.js

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

//=include ../blocks/footer/footer.js

});