<?php 
if ( $section['manual'] ) {
  $articles = $section['articles'];
} else {
  if ( is_category() ) {
    $category = $GLOBALS['quired_object']->term_id;
  } else {
    $category = $section['cateogry'];
  }

  $args = [
    'numberposts' => 6,
    'category' => $category
  ];

  if ( $section['sort_by'] === 'date' ) {
    $args['order'] = 'ASC';
    $args['orderby'] = 'date';
  } else if ( $section['sort_by'] === 'popuplar' ) {
    $args['meta_key'] = 'post_views_count';
    $args['orderby'] = 'meta_value';
  }

  $articles = get_posts( $args );
}

if ( $articles ) : ?>
  <section class="category-articles-sect <?php echo $section['view'] ?> container"<?php echo $section_id ?>>
    <h2 class="category-articles-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
    <div class="category-articles-sect__articles category-articles">
      <div class="category-articles__nav"></div> <?php
      foreach ( $articles as $article ) {
        create_article_card( [
          'object' => $article,
          'lazyload' => true
        ] );
      } ?>
    </div>
  </section> <?php
endif ?>