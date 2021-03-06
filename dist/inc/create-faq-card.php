<?php
function create_faq_card( $args ) {

  if ( is_object( $args['object'] ) ) {
    $faq = $args['object'];
    $faq_id = $faq->ID;
    $faq_title = $faq->post_title;

    $faq_fields = get_fields( $faq_id );
    $author_id = $faq_fields['expert'];
    $author_url = get_author_posts_url( $author_id );
    $avatar_id = get_the_author_meta( 'avatar', $author_id );
    $avatar_url = wp_get_attachment_url( $avatar_id );
    $author_name = get_the_author_meta( 'display_name', $author_id );

    $avatar_webp_url = str_replace( ['.png', '.jpg'], '.webp', $avatar_url );

    $faq_category = $faq_fields['category'];
    $faq_answer = $faq_fields['answer'];

    $faq_category_link = get_term_link( $faq_category->term_id );
  }/* else {
    $article_title = $args['title'];
    $article_descr = $args['descr'];
  }*/

  $defaults = [
    'lazyload' => false,
    'classes' => '',
    'print' => true,
    'default_class' => 'faq-card'
  ];

  $parsed_args = wp_parse_args( $args, $defaults );

  if ( $parsed_args['lazyload'] ) {
    $lazy_class = ' lazy';
    $img_attr = 'src="#" data-src=\'';
    $src_attr = 'srcset="#" data-srcset=\'';
  } else {
    $lazy_class = '';
    $img_attr = 'src=\'';
    $src_attr = 'srcset=\'';
  }

  $card_class = $parsed_args['default_class'];

  // var_dump( stripos( $faq_answer, '\n' ) );
  // var_dump( preg_match( '/\n/', $faq_answer, $M ) );
  // var_dump( $M );
  // if ( strlen( $faq_answer ) > 150 ) {
    $faq_answer = preg_replace_callback( '/\n[\s\S]*/', function( $matches ) {
      return "<details class='faq-card__answer-details'><summary class='faq-card__answer-summary'>Показать весь ответ...</summary><p>{$matches[0]}</p></details>";
    }, $faq_answer );  
  // }

  $response = 
  "<div class='{$card_class}' data-post-id='{$faq_id}'>
    <p class='{$card_class}__title'>{$faq_title}</p>
    <div class='{$card_class}__author'>
      <a href='{$author_url}' class='{$card_class}__author-pic-link'>
        <picture class='{$card_class}__author-pic{$lazy_class}'>
          <source type='image/webp' {$src_attr}{$avatar_webp_url}'>
          <img {$img_attr}{$avatar_url}' alt='{$author_name}' class='{$card_class}__author-img'>
        </picture>
      </a>
      <div class='{$card_class}__author-text'>
        <a href='{$author_url}' class='{$card_class}__author-title'>{$author_name}</a>
        <a href='{$faq_category_link}' class='{$card_class}__author-category'>{$faq_category->name}</a>
      </div>
    </div>
    <p class='{$card_class}__answer'>{$faq_answer}</p>
  </div>";

  if ( $parsed_args['print'] ) {
    echo $response;
  } else {
    return $response;
  }
}