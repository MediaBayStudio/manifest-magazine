//=include components/utils.js

document.addEventListener('DOMContentLoaded', function() {
  body = document.body;

  //=include components/telMask.js

  //=include components/validateForms.js

  //=include components/menu.js

  //=include components/loadmore.js

  // В основном для IE
  if (!NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
  }

  if (!HTMLCollection.prototype.forEach) {
    HTMLCollection.prototype.forEach = Array.prototype.forEach;
  }

  fakeScrollbar = id('fake-scrollbar');

  burger = q('.hdr__burger');

  hdr = q('.hdr');

  menu = mobileMenu({
    menu: q('.menu'),
    menuCnt: q('.menu__cnt'),
    openBtn: burger,
    closeBtn: q('.menu__close'),
    fade: true,
    allowPageScroll: false
  });

  // menu.open();

  let links = qa('a[href^="#"]');

  console.log(links);

  for (let i = 0, len = links.length; i < len; i++) {
    links[i].addEventListener('click', scrollToTarget);
  }

  sticky(hdr);

  // thanksPopup = new Popup('.thanks', {
  // closeButtons: '.thanks__close'
  // });


  window.svg4everybody && svg4everybody();

  // Добавление расчета vh на ресайз окна
  windowFuncs.resize.push(setVh);

  // Сбор событий resize, load, scroll и установка на window
  for (let eventType in windowFuncs) {
    if (eventType !== 'call') {
      let funcsArray = windowFuncs[eventType];
      if (funcsArray.length > 0) {
        windowFuncs.call(funcsArray);
        window.addEventListener(eventType, windowFuncs.call);
      }
    }
  }

  // настройки grab курсора на всех слайдерах
  // let slickLists = $('.slick-list.draggable');

  // slickLists.on('mousedown', function() {
  //   $(this).addClass('grabbing');
  // }).on('beforeChange', function() {
  //   $(this).removeClass('grabbing');
  // });

  // $(document).on('mouseup', function() {
  //   slickLists.removeClass('grabbing');
  // });

  // Инициализация lazyload
  // lazy = new lazyload({
  //   clearSrc: true,
  //   clearMedia: true
  // });

  lax.init();
  lax.addDriver('scrollY', function() {
    return window.scrollY;
  });

  lax.addElements('.articles-sect__decor-star', {
    scrollY: {
      translateX: [
        ['screenHeight/2', 1250],
        {
          1024: [0, 120],
          1280: [0, 360],
          1920: [0, 485]
        }
      ],
      translateY: [
        ['screenHeight/2', 1250],
        {
          1024: [0, 415],
          1280: [0, 410],
          1920: [0, 425]
        }
      ]
    }
  });
});