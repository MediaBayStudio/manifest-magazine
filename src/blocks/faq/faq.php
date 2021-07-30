<?php

$numberposts = is_page_template( 'authors.php' ) ? 6 : 3;

$faq_posts = get_posts( [
  'post_type' => 'author_question',
  'numberposts' => $numberposts,
  'orbder' => 'ASC'
] );

$posts = array_fill( 0, $numberposts, $faq_posts[0] );

if ( $faq_posts ) :
  $section_class = is_front_page() ? 'sect-lightblue-bg' : 'sect' ?>
  <section class="faq-sect container <?php echo $section_class ?> loadmore-sect">
    <h2 class="faq-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
    <div class="faq-sect__faq faq-block loadmore-block"> <?php
      foreach ( $posts as $faq ) {
        create_faq_card( [
          'object' => $faq,
          'lazyload' => true
        ] );
      } ?>
    </div>
    <button type="button" class="faq-sect__btn btn loadmore-btn" data-post-type="author_question" data-grid-masonry="false" data-numberposts="<?php echo $numberposts ?>" data-posts-count-mobile="2" data-posts-count-desktop="<?php echo $numberposts ?>" data-mobile-media-query="(max-width:1023.98px)">Загрузить еще</button>
  </section> <?php
endif ?>