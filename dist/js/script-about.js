document.addEventListener('DOMContentLoaded', function() {

//=include ../blocks/header/header.js

//=include ../blocks/mobile-menu/mobile-menu.js

//=include ../blocks/about-hero/about-hero.js

//=include ../blocks/about-concept/about-concept.js

;
(function() {
  let teamSlider = q('.team'),
    slidesSelector = '.team-card',
    $teamSlider = $(teamSlider),
    slides = qa(slidesSelector, teamSlider),
    slidesLength = slides.length,
    buildSlider = function() {
      if (media('(min-width:1023.98px)') && slidesLength < 5) {
        if (SLIDER.hasSlickClass($teamSlider)) {
          SLIDER.unslick($teamSlider);
        }
      } else if (media('(min-width:767.98px)') && slidesLength < 4) {
        if (SLIDER.hasSlickClass($teamSlider)) {
          SLIDER.unslick($teamSlider);
        }
      } else if (media('(min-width:575.98px)') && slidesLength < 3) {
        if (SLIDER.hasSlickClass($teamSlider)) {
          SLIDER.unslick($teamSlider);
        }
      } else {
        if (SLIDER.hasSlickClass($teamSlider)) {
          // слайдер уже создан
          return;
        }
        if (slidesLength > 1) {
          $teamSlider.slick({
            slide: slidesSelector,
            draggable: false,
            appendArrows: $('.team__nav', $teamSlider),
            prevArrow: SLIDER.createArrow('team__prev', SLIDER.arrowSvg),
            nextArrow: SLIDER.createArrow('team__next', SLIDER.arrowSvg),
            infinite: false,
            mobileFirst: true,
            responsive: [{
              breakpoint: 575.98,
              settings: {
                slidesToShow: 2
              }
            }, {
              breakpoint: 767.98,
              settings: {
                slidesToShow: 3
              }
            }, {
              breakpoint: 1023.98,
              settings: {
                slidesToShow: 4
              }
            }]
          });
        }
      };
    }

  buildSlider();
  windowFuncs.resize.push(buildSlider);
})();

//=include ../blocks/about-prize/about-prize.js

//=include ../blocks/footer/footer.js

});