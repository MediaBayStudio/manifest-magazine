;
(function() {
  let articlesSect = id('author-hero-articles-sect'),
    categoriesBlock = q('.author-hero-articles-sect__categories', articlesSect),
    categoriesBlockLine = q('hr', articlesSect),
    activeButton = q('button.active', categoriesBlock),
    articlesBlockSelector = '.author-hero-articles-sect__block',
    setLinePosition = function(left, width) {
      if (left !== false) {
        categoriesBlockLine.style.transform = 'translate3d(' + left + 'px, 0, 0)';
      }
      if (width !== false) {
        categoriesBlockLine.style.width = width / 2 + 'px';
      }
    };

    setLinePosition(false, activeButton.offsetWidth);

  categoriesBlock.addEventListener('click', function(e) {
    let target = e.target;

    if (target.classList.contains('author-hero-articles-sect__category-btn')) {
      let categoryId = target.getAttribute('data-category-id'),
        blockSelector = articlesBlockSelector + '[data-category-id="' + categoryId + '"]',
        activeButton = q('button.active', categoriesBlock),
        activeBlock = q(articlesBlockSelector + '.active', articlesSect),
        selectedBlock = q(blockSelector, articlesSect);

      activeButton.classList.remove('active');
      activeBlock.classList.remove('active');

      selectedBlock.classList.add('active');
      target.classList.add('active');

      console.log(blockSelector);
      console.log(selectedBlock);

      setLinePosition(target.offsetLeft, target.offsetWidth);


    }
  });
})();