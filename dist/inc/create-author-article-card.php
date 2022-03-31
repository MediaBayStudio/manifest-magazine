<?php
function create_author_article_card( $args ) {

  if ( is_object( $args['object'] ) ) {
    $author_id = $args['object']->post_author;
    $author_url = get_author_posts_url( $author_id );

    $avatar_id = get_the_author_meta( 'avatar', $author_id );
    $avatar_url = wp_get_attachment_url( $avatar_id );
    $avatar_webp_url = str_replace( ['.png', '.jpg'], '.webp', $avatar_url );
    $avatar_name = get_the_author_meta( 'display_name', $author_id );

    $article = $args['object'];
    $article_id = $article->ID;
    $article_title = $article->post_title;
    $article_descr = get_excerpt( [
      'text' => $args['object']->post_content,
      'maxchar'   =>  120,
      'autop' => false,
      'ignore_more' => true
    ] );
    $article_permalink = get_the_permalink( $article_id );
    $article_thumbnail_id = get_post_thumbnail_id( $article_id );
    $article_img_url = image_get_intermediate_size( $article_thumbnail_id, 'author_article' )['url'];

    if ( !$article_img_url ) {
      $article_img_url = image_get_intermediate_size( $article_thumbnail_id, 'mobile' )['url'];
    }

    $article_img_alt = $article_title;
    $article_img_webp = str_replace( ['.png', '.jpg', '.jpeg'], '.webp', $article_img_url );
    // $article_img_url = get_the_post_thumbnail_url( $article_id );
    // $article_img_alt = $article_title;
    // $article_img_webp = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $article_img_url );
    $article_categories = get_the_terms( $article_id, 'category' );
    foreach ( $article_categories as $category ) {
      if ( $category->parent ) {
        $article_child_category = $category;
      } else {
        $article_parent_category = $category;
      }
    }
  } else {
    $article_title = $args['title'];
    $article_descr = $args['descr'];
  }

  if ( !$article_parent_category ) {
    $article_parent_category = get_term( $article_child_category->parent );
  }

  $defaults = [
    'lazyload' => false,
    'classes' => '',
    'print' => true
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

  $img_style = '';
  switch ( $article_id ) {
    case 3297:
      $img_style = ' style="object-position:left"';
      break;
  }

  $response =
  '<article class="author-article-card' . $parsed_args['classes'] . '" data-post-id="' . $article_id . '">
    <a href="' . $article_permalink . '" class="author-article-card__pic-link">
      <picture class="author-article-card__pic' . $lazy_class . '">
        <source type="image/webp" ' . $src_attr . $article_img_webp . '">
        <img ' . $img_attr . $article_img_url . '" ' . $img_style . ' alt="' . esc_attr( $article_img_alt ) . '" class="author-article-card__img">
      </picture>
    </a>
    <div class="author-article-card__text">
      <div class="author-article-card__author">
        <a href="' . $author_url . '" class="author-article-card__author-pic-link">
          <picture class="author-article-card__author-pic' . $lazy_class . '">
            <source type="image/webp" ' . $src_attr . $avatar_webp_url . '">
            <img ' . $img_attr . $avatar_url . '" alt="' . $avatar_name . '" class="author-article-card__img">
          </picture>
        </a>
        <div class="author-article-card__author-text">
          <a href="' . $author_url . '" class="author-article-card__author-name">' . $avatar_name . '</a>
          <a href="' . get_term_link( $article_parent_category ) . '" class="author-article-card__category">' . $article_parent_category->name . '</a>
        </div>
      </div>
      <a href="' . $article_permalink . '" class="author-article-card__title-link">
        <h3 class="author-article-card__title">' . $article_title . '</h3>
      </a>
    </div>
  </article>';

  if ( $parsed_args['print'] ) {
    echo $response;
  } else {
    return $response;
  }
}