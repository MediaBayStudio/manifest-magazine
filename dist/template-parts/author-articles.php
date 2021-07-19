<?php
$articles = $section['articles']; 
if ( $articles ) : ?>
  <section class="author-articles-sect sect container"<?php echo $section_id ?>>
    <h2 class="author-articles-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
    <div class="author-articles-sect__articles <?php echo $section['view'] ?>"> <?php
    if ( $section['view'] === 'author-articles-masonry' ) : ?>
      <div class="gutter-size"></div> <?php
    endif;
      foreach ( $articles as $article ) {

        create_author_article_card( [
          'article' => $article,
          'lazyload' => true
        ] );
        
        // create_article_card( [
        //   'article' => $article,
        //   'lazyload' => true
        // ] );
        // create_article_card( [
        //   'article' => $article,
        //   'lazyload' => true
        // ] );
        // create_article_card( [
        //   'article' => $article,
        //   'lazyload' => true
        // ] );
        // create_article_card( [
        //   'article' => $article,
        //   'lazyload' => true
        // ] );
        // create_article_card( [
        //   'article' => $article,
        //   'lazyload' => true
        // ] );
        // break;
      } ?>
    </div> <?php
    if ( $section['view'] === 'author-articles-masonry' ) : ?>
      <button type="button" class="author-articles-sect__loadmore btn" data-post-type="post" data-post-author="1">Загрузить еще</button> <?php
    endif ?>
  </section> <?php
endif ?>