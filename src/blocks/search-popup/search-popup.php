<div class="search-popup popup">
  <div class="search-popup__cnt popup__cnt">
    <button type="button" class="search-popup__close popup__close">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 20" class="search-popup__close-svg popup__close-svg"><path stroke="currentColor" d="M20.4455.353553L1.35359 19.4454M19.7384 19.4455L.646481.353591" class="search-popup__close-path"/></svg>
    </button>
    <span class="search-popup__title sect-h1">Поиск</span> <?php
    get_search_form() ?>
    <div class="search-popup__categories">
      <span class="search-popup__categories-title">Популярные запросы: </span> <?php
      $terms = get_terms( [
        'taxonomy' => 'category',
        'number' => 3,
        'orderby' => 'rand'
      ] );
      foreach ( $terms as $term ) : ?>
        <a href="<?php echo $site_url . '/?s=' . $term->name ?>" class="search-popup__category-link"><?php echo $term->name ?></a> <?php
      endforeach ?>
    </div>
  </div>
</div>