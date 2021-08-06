<?php

$posts_count = wp_count_posts( 'author_question' )->publish;
$numberposts = is_page_template( 'authors.php' ) ? 6 : 3;

$loadmore_btn_class = $posts_count <= $numberposts ? ' hide' : '';

$faq_posts = get_posts( [
  'post_type' => 'author_question',
  'numberposts' => $numberposts,
  'orbder' => 'ASC'
] );

if ( $faq_posts ) :
  $section_class = is_front_page() ? 'sect-lightblue-bg' : 'sect' ?>
  <section class="faq-sect container <?php echo $section_class ?> loadmore-sect">
    <h2 class="faq-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
    <div class="faq-sect__faq faq-block loadmore-block"> <?php
      foreach ( $faq_posts as $faq ) {
        create_faq_card( [
          'object' => $faq,
          'lazyload' => true
        ] );
      } ?>
    </div>
    <button type="button" class="faq-sect__btn btn loadmore-btn<?php echo $loadmore_btn_class ?>" data-posts-count="<?php echo $posts_count ?>" data-post-type="author_question" data-grid-masonry="false" data-numberposts="<?php echo $numberposts ?>" data-posts-count-mobile="2" data-posts-count-desktop="<?php echo $numberposts ?>" data-order="ASC" data-mobile-media-query="(max-width:1023.98px)">Загрузить еще</button>
  </section> <?php
endif ?>