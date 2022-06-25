<?php
// Если в аргументах передан объект статьи
// то другие аргументы статьи не учитываем
// и из объекта берем заголовок, описание, изображение и т.д.

function create_article_card( $args ) {

  $queried_object = get_queried_object();

  if ( $queried_object->term_id ) {
    $queried_term = $queried_object;
  }

  if ( is_object( $args['object'] ) ) {
    $article = $args['object'];
    $article_id = $article->ID;
    $article_title = $article->post_title;
    $excerpt = get_the_excerpt( $article->ID );
    if ( !$excerpt ) {
      $excerpt = $args['object']->post_content;
    }
    $article_descr = get_excerpt( [
      'text' => $excerpt,
      'maxchar'   =>  120,
      'autop' => false,
      'ignore_more' => true
    ] );
    $article_permalink = get_the_permalink( $article_id );
    $article_categories = get_the_terms( $article_id, 'category' );

    foreach ( $article_categories as $category ) {
      if ( $category->parent ) {
        // if ( $queried_term ) {
          // if ( $category->parent === $queried_term->term_id ) {
            // $article_child_category = $category;
          // }
        // } else {
          $article_child_category = $category;
        // }
      } else {
        // if ( $queried_term ) {
          // if ( $category->term_id === $queried_term->term_id ) {
            // $article_parent_category = $category;
          // }
        // } else {
          $article_parent_category = $category;
        // }
      }
    }
  } else {
    $article_title = $args['title'];
    $article_descr = $args['descr'];
  }

  $defaults = [
    'lazyload' => false,
    'classes' => '',
    'print' => true,
    'default_class' => 'article-card'
  ];

  $parsed_args = wp_parse_args( $args, $defaults );

  if ( $parsed_args['lazyload'] ) {
    $lazy_class = ' lazy';
    $img_attr = 'src="#" data-src="';
    $src_attr = 'srcset="#" data-srcset="';
  } else {
    $lazy_class = '';
    $img_attr = 'src="';
    $src_attr = 'srcset="';
  }

  $card_class = $parsed_args['default_class'];


  if ( $card_class === 'category-hero-article-card' ) {
    $img_size = 'tablet';
    $img_size_2x = 'desktop';
  } else {
    $img_size = 'mobile';
    $img_size_2x = 'laptop';
  }

  $article_thumbnail_id = get_post_thumbnail_id( $article_id );
  $article_img = image_get_intermediate_size( $article_thumbnail_id, $img_size );
  $article_img_webp = image_get_intermediate_size( $article_thumbnail_id, $img_size . '_webp' );
  $article_img_2x = image_get_intermediate_size( $article_thumbnail_id, $img_size_2x );
  $article_img_webp_2x = image_get_intermediate_size( $article_thumbnail_id, $img_size_2x . '_webp' );
  $article_img_alt = $article_title;

  if ( !$article_img ) {
    $article_img = image_get_intermediate_size( $article_thumbnail_id, 'mobile' );
    $article_img_webp = image_get_intermediate_size( $article_thumbnail_id, 'mobile_webp' );
  }

  if ( !$article_img_2x ) {
    $article_img_2x = ['url' => wp_get_original_image_url( $article_thumbnail_id )];
    $article_img_webp_2x = ['url' => wp_get_original_image_url( $article_thumbnail_id )];
  }

  $article_img_url = $article_img['url'];
  $article_img_webp_url = $article_img_webp['url'];
  $article_img_2x_url = $article_img_2x['url'];
  $article_img_webp_2x_url = $article_img_webp_2x['url'];

  $img_style = '';
  switch ( $article_id ) {
    case 3297:
      $img_style = ' style="object-position:left"';
      break;
  }

  $response =
  '<article class="' . $card_class . $parsed_args['classes'] . '" data-post-id="' . $article_id . '">
    <a href="' . $article_permalink . '" class="' . $card_class . '__link">
      <picture class="' . $card_class . '__pic' . $lazy_class . '">
        <source type="image/webp" ' . $src_attr . $article_img_webp_url . ', ' . $article_img_webp_2x_url . ' 2x">
        <img ' . $img_attr . $article_img_url . '"' . $img_style . ' alt="' . esc_attr( $article_img_alt ) . '" class="' . $card_class . '__img">
      </picture>
    </a>';
    if ( $card_class === 'category-hero-article-card' ) {
      $response .= '<div class="' . $card_class . '__text">';
    }
    $response .= '
    <div class="' . $card_class . '__categories">';
    if ( $article_parent_category ) {
      $response .=
      '<a href="' . get_term_link( $article_parent_category ) . '" class="' . $card_class . '__parent-category">' . $article_parent_category->name . '</a>';
    }
    if ( $article_parent_category && $article_child_category ) {
      $response .= 
      ' / ';
    }

    if ( $article_child_category ) {
      $response .=
      '<a href="' . get_term_link( $article_child_category ) . '" class="' . $card_class . '__child-category">' . $article_child_category->name . '</a>';
    }
    $response .=
    '</div>
    <a href="' . $article_permalink . '" class="' . $card_class . '__link">
      <h3 class="' . $card_class . '__title">' . $article_title . '</h3>
    </a>
    <p class="' . $card_class . '__descr">' . $article_descr . '</p>';
    if ( $card_class === 'category-hero-article-card' ) {
      $response .= '</div>';
    }
    $response .= '
  </article>';

  if ( $parsed_args['print'] ) {
    echo $response;
  } else {
    return $response;
  }
}