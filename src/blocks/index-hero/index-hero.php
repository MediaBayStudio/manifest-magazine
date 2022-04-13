<section class="index-hero-sect container"<?php echo $section_id ?>>
  <img src="<?php echo $template_directory_uri ?>/img/words-circle.svg" alt="#" class="index-hero-sect__circle"> <?php
  if ( $section['manual'] ) {
    $index_hero_slides = $section['slider'];
  } else {
    $index_hero_slides = get_posts( [
      'order' => 'DESC',
      'numberposts' => $section['numberposts']
    ] );
  }

  $i = 0;
  foreach ( $index_hero_slides as $slide ) :
    $single = $section['manual'] ? $slide['single'] : $slide;
    $single_id = $single->ID;
    $permalink = get_the_permalink( $single_id );
    $categories = get_the_terms( $single_id, 'category' );
    $fields = get_fields( $single_id );

    if ( $fields['use_small_image'] ) {
      $image = $fields['small_image'];
      $slide_class_name = ' small-img';

      if ( $image ) {
        $image_id = $image['ID'];
        $img_alt = $image['alt'];
      } else {
        $image_id = get_post_thumbnail_id( $single_id );
        $img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $image = image_get_intermediate_size( $image_id, 'mobile' );
      }

      $image_webp = image_get_intermediate_size( $image_id, 'mobile_webp' );

      if ( !$image_webp ) {
        $image_webp = image_get_intermediate_size( $image_id, 'webp' );
      }

      $image_url = $image['url'];
    } else {
      $image = $fields['big_image'];
      $slide_class_name = ' big-img';

      if ( $image ) {
        $image_id = $image['ID'];
        $img_alt = $image['alt'];
      } else {
        $image_id = get_post_thumbnail_id( $single_id );
        $img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
      }

      $image_url = get_the_post_thumbnail_url( $single_id );

      $image_webp = image_get_intermediate_size( $image_id, 'webp' );
      $image_desktop = image_get_intermediate_size( $image_id, 'desktop');
      $image_laptop = image_get_intermediate_size( $image_id, 'laptop');
      $image_tablet = image_get_intermediate_size( $image_id, 'tablet');
      $image_mobile = image_get_intermediate_size( $image_id, 'mobile');

      if ( $image_desktop ) {
        $image_desktop_webp = image_get_intermediate_size( $image_id, 'desktop_webp');
        if ( $image_desktop ) {
          $image_desktop_url = $image_desktop['url'];
        }
        if ( $image_desktop_webp ) {
          $image_desktop_webp_url = $image_desktop_webp['url'];
        }
      }

      if ( $image_laptop ) {
        $image_laptop_webp = image_get_intermediate_size( $image_id, 'laptop_webp');
        if ( $image_laptop ) {
          $image_laptop_url = $image_laptop['url'];
        }
        if ( $image_laptop_webp ) {
          $image_laptop_webp_url = $image_laptop_webp['url'];
        }
      }

      if ( $image_tablet ) {
        $image_tablet_webp = image_get_intermediate_size( $image_id, 'tablet_webp');
        if ( $image_tablet ) {
          $image_tablet_url = $image_tablet['url'];
        }
        if ( $image_tablet_webp ) {
          $image_tablet_webp_url = $image_tablet_webp['url'];
        }
      }

      if ( $image_mobile ) {
        $image_mobile_webp = image_get_intermediate_size( $image_id, 'mobile_webp');
        if ( $image_mobile ) {
          $image_mobile_url = $image_mobile['url'];
        }
        if ( $image_mobile_webp ) {
          $image_mobile_webp_url = $image_mobile_webp['url'];
        }
      }
    }

    $image_webp_url = $image_webp['url'];

    if ( !$img_alt ) {
      $img_alt = $single->post_title;
    }

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

    if ( $image_desktop_url ) {
      if ( $image_desktop_webp_url ) {
        $picture .= '<source type="image/webp" media="(min-width:1279.98px)" ' . $source_attr . $image_desktop_webp_url . '">';
      }
      $picture .= '<source type="' . $image_desktop['mime-type'] . '" media="(min-width:1279.98px)" ' . $source_attr . $image_desktop_url . '">';
    }

    if ( $image_laptop_url ) {
      if ( $image_laptop_webp_url ) {
      $picture .= '<source type="image/webp" media="(min-width:767.98px) and (max-width:1023.98px)" ' . $source_attr . $image_laptop_webp_url . '">';        
      }
      $picture .= '<source type="' . $image_laptop['mime-type'] . '" media="(min-width:767.98px) and (max-width:1023.98px)" ' . $source_attr . $image_laptop_url . '">';
    }

    if ( $image_tablet_url ) {
      if ( $image_tablet_webp_url ) {
        $picture .= '<source type="image/webp" media="(min-width:575.98px) and (max-width:767.98px)" ' . $source_attr . $image_tablet_webp_url . '">';
      }
      $picture .= '<source type="' . $image_tablet['mime-type'] . '" media="(min-width:575.98px) and (max-width:767.98px)" ' . $source_attr . $image_tablet_url . '">';
    }

    if ( $image_mobile_url ) {
      if ( $image_mobile_webp_url ) {
        $picture .= '<source type="image/webp" media="(max-width:575.98px)" ' . $source_attr . $image_mobile_webp_url . '">';
      }
      $picture .= '<source type="' . $image_mobile['mime-type'] . '" media="(max-width:575.98px)" ' . $source_attr . $image_mobile_url . '">';
    }

    $picture .= '<source type="image/webp" ' . $source_attr . $image_webp_url . '">';

    $picture .= '<img ' . $img_attr . $image_url . '" alt="' . esc_attr( $img_alt ) . '" class="index-hero-slide__img">';

    $picture .= '</picture>';

    foreach ( $categories as $category ) {
      if ( $category->parent ) {
        $child_category = $category;
      } else {
        $parent_category = $category;
      }
    } ?>
    <div class="index-hero-sect__slide index-hero-slide<?php echo $slide_class_name ?>">
      <a href="<?php echo $permalink ?>" class="index-hero-slide__pic-link"> <?php
        echo $picture ?>
      </a>
      <div class="index-hero-slide__text">
        <div class="index-hero-slide__categories"> <?php
          if ( $parent_category ) : ?>
            <a href="<?php echo get_term_link( $parent_category ) ?>" class="index-hero-slide__parent-category"><?php echo $parent_category->name ?></a> <?php
          endif;
          if ( $parent_category && $child_category ) : ?>
            / <?php
          endif;
          if ( $child_category ) : ?>
            <a href="<?php echo get_term_link( $child_category ) ?>" class="index-hero-slide__child-category"><?php echo $child_category->name ?></a> <?php
          endif ?>
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
    <span class="slider-progress__total-number"><?php echo substr( "0$i", -2 ) ?></span>
  </div>
</section>