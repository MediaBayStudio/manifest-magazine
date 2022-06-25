<?php
$inspiration = $section['inspiration'];
if (!$inspiration) {
  $inspiration = get_posts( [
    'post_type' => 'inspiration',
    'numberposts' => 1
  ] )[0];
}

if ( $section['day'] != date( 'd' ) ) {
  // Ищем новый пост
  $inspiration = get_posts( [
    'post_type' => 'inspiration',
    'numberposts' => 1,
    'exclude' => $section['exclude']
  ] );

  // Добавим его в исключения
  if ( $section['exclude'] ) {
    $section['exclude'] .= ' ' . $inspiration[0]->ID;
  } else {
    $section['exclude'] = $inspiration[0]->ID;
  }

  // Если поста нет или он тот же самый, то берем новый
  if ( !$inspiration ) {
    $inspiration = get_posts( [
      'post_type' => 'inspiration',
      'numberposts' => 1
    ] );
    $section['exclude'] = $inspiration[0]->ID;
  }

  $inspiration = $inspiration[0];

  $section['day'] = date( 'd' );
  $section['inspiration'] = $inspiration->ID;
  $sections[ $section_index ] = $section;
  update_field( 'sections', $sections, 2 );
}

$inspiration_fields = get_fields( $inspiration->ID );
$author = $inspiration_fields['author'];
$image = wp_get_attachment_image_url( $inspiration_fields['img']['id'], 'thumb' );
$image_webp = str_replace( ['.jpg', '.png'], '.webp', $image ) ?>

<section class="index-quote-sect sect container lazy"<?php echo $section_id ?> data-src="#">
  <h2 class="index-quote-sect__title sect-title sect-title-underline">Вдохновение дня</h2>
  <div class="index-quote-sect__pic-wrap">
    <picture class="index-quote-sect__pic lazy">
      <source type="image/webp" srcset="#" data-srcset="<?php echo $image_webp ?>">
      <img src="#" alt="#" data-src="<?php echo $image ?>" class="index-quote-sect__img">
    </picture>
  </div>
  <div class="index-quote-block">
    <p class="index-quote-block__text"><?php echo $inspiration_fields['text'] ?></p> <?php
    if ( $author ) : ?>
      <span class="index-quote-block__author"><?php echo $author ?></span> <?php
    endif ?>
  </div>
</section>