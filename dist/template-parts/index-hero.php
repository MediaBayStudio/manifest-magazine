<?php 

if ( $section['slider_view'] === 'full_screen_img' ) {
  $section_class = 'full-screen';
} else {
  $section_class = 'small-img';
} ?>
<section class="index-hero-sect <?php echo $section_class ?> container"<?php echo $section_id ?>> <?php
if ( $section['slider_view'] !== 'full_screen_img' ) : ?>
  <img src="<?php echo $template_directory_uri ?>/img/words-circle.svg" alt="#" class="index-hero-sect__circle"> <?php
endif;
$i = 0;
foreach ( $section['slider'] as $slide ) :
  $single = $slide['single'];
  $single_id = $single->ID;
  $permalink = get_the_permalink( $single_id );
  $categories = get_the_terms( $single_id, 'category' );

  $img = ($section['slider_view'] === 'full_screen_img' ? $slide['full_screen_img'] : $slide['small_img']);
  $img_id = $img['id'];

  $desktop_url = image_get_intermediate_size( $img_id, 'desktop' );
  $laptop_url = image_get_intermediate_size( $img_id, 'laptop' );
  $tablet_url = image_get_intermediate_size( $img_id, 'tablet' );
  $mobile_url = image_get_intermediate_size( $img_id, 'mobile' );
  $webp_url = str_replace( ['.jpg', '.png'], '.webp', $img['url'] );

  if ( $i === 0 ) {
    $picture_class = '';
    $img_attr = 'src="';
    $source_attr = 'srcset="';
  } else {
    $picture_class = ' lazy';
    $img_attr = 'src="#" data-src="';
    $source_attr = 'srcset="#" data-srcset="';
  }

  $picture = '<picture class="index-hero-slide__pic' . $picture_class . '">';

  if ( $desktop_url ) {
    $desktop_webp_url = str_replace( ['.jpg', '.png'], '.webp', $desktop_url['url'] );
    $picture .= '<source type="image/webp" media="(min-width:1279.98px)" ' . $source_attr . $desktop_webp_url . '">';
    $picture .= '<source type="image/jpeg" media="(min-width:1279.98px)" ' . $source_attr . $desktop_url['url'] . '">';
  }

  if ( $laptop_url ) {
    $laptop_webp_url = str_replace( ['.jpg', '.png'], '.webp', $laptop_url['url'] );
    $picture .= '<source type="image/webp" media="(min-width:767.98px) and (max-width:1023.98px)" ' . $source_attr . $laptop_webp_url . '">';
    $picture .= '<source type="image/jpeg" media="(min-width:767.98px) and (max-width:1023.98px)" ' . $source_attr . $laptop_url['url'] . '">';
  }

  if ( $tablet_url ) {
    $tablet_webp_url = str_replace( ['.jpg', '.png'], '.webp', $tablet_url['url'] );
    $picture .= '<source type="image/webp" media="(min-width:575.98px) and (max-width:767.98px)" ' . $source_attr . $tablet_webp_url . '">';
    $picture .= '<source type="image/jpeg" media="(min-width:575.98px) and (max-width:767.98px)" ' . $source_attr . $tablet_url['url'] . '">';
  }

  if ( $mobile_url ) {
    $mobile_webp_url = str_replace( ['.jpg', '.png'], '.webp', $mobile_url['url'] );
    $picture .= '<source type="image/webp" media="(max-width:575.98px)" ' . $source_attr . $mobile_webp_url . '">';
    $picture .= '<source type="image/jpeg" media="(max-width:575.98px)" ' . $source_attr . $mobile_url['url'] . '">';
  }

  $picture .= '<source type="image/webp"' . $source_attr . $webp_url . '">';

  $picture .= '<img ' . $img_attr . $img['url'] . '" alt="#" class="index-hero-slide__img">';

  $picture .= '</picture>';

  foreach ( $categories as $cat ) {
    if ( $cat->parent ) {
      $child_category = $cat;
    } else {
      $parent_category = $cat;
    }
  } ?>
  <div class="index-hero-sect__slide index-hero-slide">
    <a href="<?php echo $permalink ?>" class="index-hero-slide__pic-link"> <?php
      echo $picture ?>
    </a>
    <div class="index-hero-slide__text">
      <div class="index-hero-slide__categories">
        <a href="<?php echo get_term_link( $parent_category ) ?>" class="index-hero-slide__parent-category"><?php echo $parent_category->name ?></a>
        /
        <a href="<?php echo get_term_link( $child_category ) ?>" class="index-hero-slide__child-category"><?php echo $child_category->name ?></a>
      </div>
      <a href="<?php echo $permalink ?>" class="index-hero-slide__title-link"><h2 class="index-hero-slide__title"><?php echo $single->post_title ?></h2></a>
      <p class="index-hero-slide__descr"><?php echo get_the_excerpt( $single_id ) ?></p>
    </div>
  </div> <?php
  $i++;
endforeach ?>
<div class="index-hero-sect__progress slider-progress">
  <span class="slider-progress__current-number">01</span>
  <div class="slider-progress__bar">
    <div class="slider-progress__background"></div>
  </div>
  <span class="slider-progress__total-number">0<?php echo $i ?></span>
</div>
</section>
