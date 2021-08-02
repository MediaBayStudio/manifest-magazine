document.addEventListener('DOMContentLoaded', function() {

//=include ../blocks/header/header.js

//=include ../blocks/mobile-menu/mobile-menu.js

//=include ../blocks/article/article.js

;
(function() {
  errorPopup = new Popup('.error-popup', {
    closeButtons: '.error-popup__close'
  });
})();


;thanksPopup = new Popup('.thanks-popup', {
  closeButtons: '.thanks-popup__close'
});



;
(function() {
  searchPopup = new Popup('.search-popup', {
    openButtons: '.hdr__search',
    closeButtons: '.search-popup__close'
  });
  
  // searchPopup.openPopup();

})();

//=include ../blocks/footer/footer.js

});