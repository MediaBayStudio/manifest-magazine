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