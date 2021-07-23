<?php 

$faq_posts = get_posts( [
  'post_type' => 'author_question',
  'numberposts' => 3,
  'orbder' => 'ASC'
] );

if ( $faq_posts ) :
  $section_class = is_front_page() ? 'sect-lightblue-bg' : 'sect' ?>
  <section class="faq-sect sect container <?php echo $section_class ?> loadmore-sect">
    <h2 class="faq-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
    <div class="faq-sect__faq faq-block loadmore-block"> <?php
      foreach ( $faq_posts as $faq ) {
        create_faq_card( [
          'object' => $faq,
          'lazyload' => true
        ] );
        create_faq_card( [
          'object' => $faq,
          'lazyload' => true
        ] );
        create_faq_card( [
          'object' => $faq,
          'lazyload' => true
        ] );
        break;
      } ?>
    </div>
    <button type="button" class="faq-sect__btn btn loadmore-btn" data-post-type="author_question" data-grid-masonry="false" data-numberposts="3" data-posts-count-mobile="2" data-posts-count-desktop="3" data-mobile-media-query="(max-width:1023.98px)">Загрузить еще</button>
  </section> <?php
endif ?>