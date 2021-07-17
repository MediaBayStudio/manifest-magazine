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