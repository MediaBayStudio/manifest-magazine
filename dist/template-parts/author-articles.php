<?php
$articles = $section['articles']; 
if ( $articles ) : ?>
  <section class="author-articles-sect sect container"<?php echo $section_id ?>>
    <img src="#" alt="#" data-src="<?php echo $template_directory_uri ?>/img/decor-star-blue.svg" class="author-articles-sect__decor-star lazy">
    <h2 class="author-articles-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
    <p class="author-articles-sect__descr"><?php echo $section['descr'] ?></p>
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
    endif ?>
  </section> <?php
endif ?>