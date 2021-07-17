<?php
  $author = $section['author'];
  $image = wp_get_attachment_image_url( $section['img']['id'], 'thumb' );
  $image_webp = str_replace( ['.jpg', '.png'], '.webp', $image ) ?>
<section class="index-quote-sect sect container lazy"<?php echo $section_id ?> data-src="#">
  <h2 class="index-quote-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="index-quote-sect__pic-wrap">
    <picture class="index-quote-sect__pic lazy">
      <source type="image/webp" srcset="#" data-srcset="<?php echo $image_webp ?>">
      <img src="#" alt="#" data-src="<?php echo $image ?>" class="index-quote-sect__img">
    </picture>
  </div>
  <div class="index-quote-block">
    <p class="index-quote-block__text"><?php echo $section['quote'] ?></p> <?php
    if ( $author ) : ?>
      <span class="index-quote-block__author"><?php echo $author ?></span> <?php
    endif ?>
  </div>
</section>