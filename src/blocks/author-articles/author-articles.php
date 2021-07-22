<?php

$is_author = is_author();

if ( $section['by_default'] ) {
  $articles = get_posts( [
    'numberposts' => 6
  ] );
  $title_tag = 'h1';
  $title_class = 'sect-h1';
  $categories = get_terms( [
    'taxonomy' => 'category',
    'parent' => 0,
    'hide_empty' => false
  ] );
} else {
  $articles = $section['articles'];
  $title_tag = 'h2';
  $title_class = 'sect-title sect-title-underline';
}

$title = '<' . $title_tag . ' class="author-articles-sect__title ' . $title_class . '">' . $section['title'] . '</' . $title_tag . '>';

if ( $articles ) : ?>
  <section class="author-articles-sect sect container"<?php echo $section_id ?>> <?php
    if ( !$section['by_default'] ) : ?>
      <img src="#" alt="#" data-src="<?php echo $template_directory_uri ?>/img/decor-star-blue.svg" class="author-articles-sect__decor-star lazy"> <?php
    endif;
    if ( $section['title'] ) {
      echo $title;
    }
    if ( $section['by_default'] ) : ?>
      <div class="author-articles-sect__bottom">
        <div class="author-articles-sect__descr-block"> <?php
    endif ?>
          <p class="author-articles-sect__descr"><?php echo $section['descr'] ?></p> <?php
      if ( $section['by_default' ] ) : ?>
          <div class="author-articles-sect__categories">
            <span class="author-articles-sect__current-category" data-id="0">Все темы</span>
            <ul class="author-articles-sect__categories-list"> <?php
              foreach ( $categories as $category ) : ?>
                <span class="author-articles-sect__category" data-id="<?php echo $category->term_id ?>"><?php echo $category->name ?></span> <?php
              endforeach ?>
            </ul>
          </div>
        </div> <?php
      endif ?>
      <div class="author-articles-sect__articles author-articles <?php echo $section['view'] ?>"> <?php
      if ( $section['view'] === 'author-articles-masonry' ) : ?>
        <div class="gutter-size"></div> <?php
      else : ?>
        <div class="author-articles-slider__nav"></div> <?php
      endif;
        foreach ( $articles as $article ) {
          create_author_article_card( [
            'article' => $article,
            'lazyload' => true
          ] );
          
          create_author_article_card( [
            'article' => $article,
            'lazyload' => true
          ] );
          
          create_author_article_card( [
            'article' => $article,
            'lazyload' => true
          ] );

          create_author_article_card( [
            'article' => $article,
            'lazyload' => true
          ] );
        } ?>
      </div> <?php
      if ( $section['view'] === 'author-articles-masonry' ) : ?>
        <button type="button" class="author-articles-sect__loadmore btn" data-post-type="post" data-post-author="1">Загрузить еще</button> <?php
      endif;
    if ( $section['by_default'] ) : ?>
      </div> <?php
    endif ?>
  </section> <?php
endif ?>