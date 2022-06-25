<?php
  // названия полей такие же как и у иконок
  $horoscope_info = [
    'oven' => 'Овен',
    'telec' => 'Телец',
    'blizneczy' => 'Близнецы',
    'rak' => 'Рак',
    'lev' => 'Лев',
    'deva' => 'Дева',
    'vesy' => 'Весы',
    'skorpion' => 'Скорпион',
    'strelecz' => 'Стрелец',
    'kozerog' => 'Козерог',
    'vodolej' => 'Водолей',
    'ryby' => 'Рыбы'
  ];

  $title = 'Астрологический прогноз на неделю с ' . date( 'd.m', strtotime( 'this week monday' ) ) . ' по ' . date( 'd.m', strtotime( 'this week sunday' ) );
  $horoscope_author = $section['author_img'];

  $mobile_img = image_get_intermediate_size( $horoscope_author['ID'], 'thumb' );
  $mobile_img_webp = image_get_intermediate_size( $horoscope_author['ID'], 'thumb_webp' );

  if ( !$mobile_img ) {
    $mobile_img = $horoscope_author;
    $mobile_img_webp = image_get_intermediate_size( $horoscope_author['ID'], 'webp' );
  }

  $mobile_img_url = $mobile_img['url'];
  $mobile_img_webp_url = $mobile_img_webp['url'];
?>
<section class="index-horoscope sect container" id="horoscope">
  <h2 class="index-horoscope__title sect-title sect-title-underline">Eженедельный гороскоп</h2>
  <div class="horoscope-author">
    <div class="horoscope-author__info">
      <picture class="horoscope-author__pic lazy">
        <source type="image/webp" srcset="#" data-srcset="<?php echo $mobile_img_webp_url ?>">
        <img src="#" alt="<?php echo $section['author_name'] ?>" data-src="<?php echo $mobile_img_url ?>" class="horoscope-author__img">
      </picture>
      <p class="horoscope-author__name"> <?php
        echo $section['author_name'] ?><br>
        <span class="horoscope-author__pos">Астролог</span>
      </p>
    </div>
    <p class="horoscope-author__descr"><?php echo $section['author_descr'] ?></p>
  </div>
  <div class="horoscope-content">
    <h3 class="horoscope-content__title horoscope-content__title-mobile"><?php echo $title ?></h3>
    <ul class="horoscope-zodiac-list"> <?php
      foreach ( $horoscope_info as $field_name => $ru_name ) : ?>
        <li class="zodiac-btn<?php echo $field_name === 'oven' ? ' active' : '' ?>" data-zodiac-name="<?php echo $ru_name ?>" data-horoscope-text="<?php echo $section[ $field_name ] ?>">
          <img src="#" data-src="<?php echo "$template_directory_uri/img/icon-zodiac-$field_name.svg" ?>" alt="<?php echo $ru_name ?>" class="zodiac-btn__icon lazy">
          <span class="zodiac-btn__name"><?php echo $ru_name ?></span>
        </li> <?php
      endforeach ?>
    </ul>
    <div class="horoscope-text">
      <p class="horoscope-content__title horoscope-content__title-desktop"><?php echo $title ?></p>
      <span class="horoscope-text__zodiac"><?php echo $horoscope_info['oven'] ?></span>
      <p class="horoscope-text__descr"><?php echo $section['oven'] ?></p>
    </div>
  </div>
</section>