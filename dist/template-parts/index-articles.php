<section class="articles-sect sect container loadmore-sect"<?php echo $section_id ?>>
  <h2 class="articles-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="articles-sect__articles loadmore-block">
    <div class="gutter-size"></div> <?php
    $posts_count = wp_count_posts()->publish;
    $numberposts = 6;

    $args = [
      'numberposts' => $numberposts
    ];

    $articles = null;

    if ( $section['sort_by'] === 'date' ) {
      $args['order'] = 'ASC';
      $args['orderby'] = 'date';
      $btn_attr = ' data-order="ASC" data-orderby="date"';
    } else if ( $section['sort_by'] === 'popuplar' ) {
      $args['meta_key'] = 'post_views_count';
      $args['orderby'] = 'meta_value_num';
      $btn_attr = ' data-meta-key="post_views_count" data-orderby="meta_value"';
      $query = get_posts( [
        'posts_per_page' => -1,
        'meta_key' => 'post_views_count'
      ] );
      $posts_count = count( $query );
    } else {
      $articles = $section['articles'];
    }

    $loadmore_btn_class = $posts_count < $numberposts ? ' hide' : '';

    if ( !$articles ) {
      $articles = get_posts( $args );
    }

    foreach ( $articles as $article ) {
      create_article_card( [
        'object' => $article,
        'lazyload' => true
      ] );
    } ?>
  </div>
  <button type="button" class="articles-sect__loadmore btn loadmore-btn<?php echo $loadmore_btn_class ?>" data-posts-count="<?php echo $posts_count ?>" data-post-type="post" data-numberposts="<?php echo $numberposts ?>" data-grid-masonry="true" data-masonry-media-query="(min-width:575.98px)" data-posts-count-mobile="4" data-posts-count-desktop="6" data-mobile-media-query="(max-width:1023.98px)"<?php echo $btn_attr ?>>Загрузить еще</button>
</section>