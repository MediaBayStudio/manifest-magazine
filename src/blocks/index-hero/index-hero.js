;
(function() {
  let slider = q('.index-hero-sect');
  let progress = q('.index-hero-sect__progress', slider);
  let progressBar = q('.slider-progress__bar', progress);
  let progressCurrentNumber = q('.slider-progress__current-number', progress);
  let progressBg = q('.slider-progress__background', progress);
  let slidesSelector = '.index-hero-sect__slide';
  let slides = qa(slidesSelector, slider);
  let $slider = $(slider);
  let isSmallImg = slider.classList.contains('small-img');
  let buildHeroSlider = function() {
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
        // autoplay: true,
        // autoplayspeed: 5000,
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
  }
  let buildDots = function() {
    let dotsHTML = '<div class="index-hero-sect__dots">';

    for (let i = 0, len = slides.length; i < len; i++) {
      dotsHTML += '<button type="button" class="index-hero-sect__dot" data-slide-index="' + i + '" style="width:calc(100% / ' + slides.length + ')"></button>';
    }

    dotsHTML += '</div>';

    progressBar.insertAdjacentHTML('afterbegin', dotsHTML);
  }

  if (progressBar) {
    progressBar.addEventListener('click', function(e) {
      let target = e.target;

      if (target.classList.contains('index-hero-sect__dot')) {
        $slider.slick('slickGoTo', target.getAttribute('data-slide-index'));
      }
    });
  }

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

    if (e.type === 'init') {
      buildDots();
    } else if (e.type === 'reInit') {
      let dotsBlock = q('.index-hero-sect__dots', progress);

      if (dotsBlock) {
        progressBg.removeChild(dotsBlock);
      }

      buildDots();
    }

    // progress.classList.toggle('last-slide', nextSlide + 1 === slides.length);
  });

  buildHeroSlider();
  windowFuncs.resize.push(buildHeroSlider);

})();