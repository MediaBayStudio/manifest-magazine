<?php

$is_author = is_author();
$articles = [];

if ( $section['by_default'] ) {

  if ( is_front_page() ) {
    $users = get_users( [
      'number' => -1,
      'orderby' => 'post_count',
      'order' => 'desc',
      'role__in' => ['author', 'editor']
    ] );

    foreach ( $users as $user ) {
      $user_posts = get_posts( [
        'numberposts' => 1,
        'order' => 'desc',
        'author' => $user->ID
      ] );
      if ( $user_posts ) {
        $articles[] = $user_posts[0];
      }
    }
  } else {
    $articles = get_posts( [
      'numberposts' => 10
    ] );
  }

  if ( $is_author || is_page_template( 'authors.php' ) ) {
    $title_tag = 'h1';
    $title_class = 'sect-h1';
    $categories = get_terms( [
      'taxonomy' => 'category',
      'parent' => 0,
      'hide_empty' => false
    ] );
    $sect_class = ' authors-page';
  } else {
    $title_tag = 'h2';
    $title_class = 'sect-title sect-title-underline';
  }
} else {
  $articles = $section['articles'];
  $title_tag = 'h2';
  $title_class = 'sect-title sect-title-underline';
}

$title = '<' . $title_tag . ' class="author-articles-sect__title ' . $title_class . '">' . $section['title'] . '</' . $title_tag . '>';

if ( $articles ) : ?>
  <section class="author-articles-sect sect container<?php echo $sect_class ?>"<?php echo $section_id ?>> <?php
    if ( !$section['by_default'] || is_front_page() ) : ?>
      <img src="#" alt="#" data-src="<?php echo $template_directory_uri ?>/img/decor-star-blue.svg" class="author-articles-sect__decor-star lazy"> <?php
    endif;
    if ( $section['title'] ) {
      echo $title;
    }
    if ( $section['by_default'] && $is_author || is_page_template( 'authors.php' ) ) : ?>
      <div class="author-articles-sect__bottom">
        <div class="author-articles-sect__descr-block"> <?php
    endif ?>
          <p class="author-articles-sect__descr"><?php echo $section['descr'] ?></p> <?php
      if ( $section['by_default' ] && $is_author || is_page_template( 'authors.php' ) ) : ?>
          <div class="author-articles-sect__categories">
            <span class="author-articles-sect__current-category" data-id="0">Все темы</span>
            <ul class="author-articles-sect__categories-list"> <?php
              foreach ( $categories as $category ) :
              if ( $category->term_id == 1) continue ?>
                <span class="author-articles-sect__category" data-id="<?php echo $category->term_id ?>"><?php echo $category->name ?></span> <?php
              endforeach ?>
            </ul>
          </div>
        </div> <?php
      endif ?>
      <div class="author-articles-sect__articles author-articles <?php echo $section['view'] ?>"> <?php
      if ( $section['view'] === 'author-articles-masonry' ) : ?>
        <!-- <div class="gutter-size"></div>  --><?php
      else : ?>
        <div class="author-articles-slider__nav"></div> <?php
      endif;
        foreach ( $articles as $article ) {
          create_author_article_card( [
            'object' => $article,
            'lazyload' => true
          ] );
        } ?>
      </div> <?php
      if ( $section['view'] === 'author-articles-masonry' ) : ?>
        <!-- <button type="button" class="author-articles-sect__loadmore btn loadmore-btn" data-cards-class="author-article-card" data-post-type="post" data-numberposts="6" data-grid-masonry="false" data-posts-count-mobile="4" data-posts-count-desktop="6" data-mobile-media-query="(max-width:767.98px)">Загрузить еще</button>  --><?php
      endif;
    if ( $section['by_default'] && $is_author || is_page_template( 'authors.php' ) ) : ?>
      </div> <?php
    endif ?>
  </section> <?php
endif ?>