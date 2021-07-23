<section class="articles-sect sect container"<?php echo $section_id ?>>
  <h2 class="articles-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="articles-sect__articles">
    <div class="gutter-size"></div> <?php
    $args = [
      'numberposts' => 9
    ];

    if ( $section['sort_by'] === 'date' ) {
      $args['order'] = 'ASC';
      $args['orderby'] = 'date';
    } else if ( $section['sort_by'] === 'popuplar' ) {
    } else {
      $articles = $section['articles'];
    }

    if ( !$articles ) {
      $articles = get_posts( $args );
    }

    foreach ( $articles as $article ) {
      create_article_card( [
        'article' => $article,
        'lazyload' => true
      ] );
      create_article_card( [
        'article' => $article,
        'lazyload' => true
      ] );
      create_article_card( [
        'article' => $article,
        'lazyload' => true
      ] );
      create_article_card( [
        'article' => $article,
        'lazyload' => true
      ] );
      create_article_card( [
        'article' => $article,
        'lazyload' => true
      ] );
      create_article_card( [
        'article' => $article,
        'lazyload' => true
      ] );
      break;
    } ?>
  </div>
  <button type="button" class="articles-sect__loadmore btn" data-post-type="post">Загрузить еще</button>
</section>