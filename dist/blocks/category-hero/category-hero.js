;(function() {
  let sections = qa('[data-id^="category-hero-sect-"]');

  sections.forEach(function(section) {
    let masonry;
    if (media('(min-width:575.98px)')) {
      masonry = new Masonry(section, {
        itemSelector: '.category-hero-article-card',
        columnWidth: '.category-hero-article-card',
        columnHeight: '.category-hero-article-card',
        gutter: '.gutter-size'
      });

      let images = qa('.category-hero-article-card__img', section);

      images.forEach(function(img) {
        img.addEventListener('load', function() {
          masonry.layout();
        });
      });
    }
  });

  console.log(sections);
})();