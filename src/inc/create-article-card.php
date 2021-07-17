<?php
// Если в аргументах передан объект статьи
// то другие аргументы статьи не учитываем
// и из объекта берем заголовок, описание, изображение и т.д.
function create_article_card( $args ) {

  if ( is_object( $args['article'] ) ) {
    $article = $args['article'];
    $article_id = $article->ID;
    $article_title = $article->post_title;
    $article_descr = get_the_excerpt( $article_id );
    $article_permalink = get_the_permalink( $article_id );
    $article_img_url = get_the_post_thumbnail_url( $article_id );
    $article_img_alt = $article_title;
    $article_img_webp = str_replace( ['.png', '.jpg'], '.webp', $article_img_url );
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

  $response =
  '<article class="article-card' . $parsed_args['classes'] . '">
    <a href="' . $article_permalink . '" class="article-card__link">
      <picture class="article-card__pic' . $lazy_class . '">
        <source type="image/webp" ' . $src_attr . $article_img_webp . '">
        <img ' . $img_attr . $article_img_url . '" alt="' . $article_img_alt . '" class="article-card__img">
      </picture>
    </a>
    <div class="article-card__categories">
      <a href="' . get_term_link( $article_parent_category ) . '" class="article-card__parent-category">' . $article_parent_category->name . '</a>
      /
      <a href="' . get_term_link( $article_child_category ) . '" class="article-card__child-category">' . $article_child_category->name . '</a>
    </div>
    <a href="' . $article_permalink . '" class="article-card__link">
      <h3 class="article-card__title">' . $article_title . '</h3>
    </a>
    <p class="article-card__descr">' . $article_descr . '</p>
  </article>';

  if ( $parsed_args['print'] ) {
    echo $response;
  } else {
    return $response;
  }
}