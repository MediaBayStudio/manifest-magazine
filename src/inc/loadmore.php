<?php

function loadmore() {

  $args = [
    'numberposts' => 6,
    'post_type' => $_POST['post_type']
  ];

  $posts = get_posts( $args );

  switch ( $_POST['post_type'] ) {
    case 'author_question':
      $func = 'create_faq_card';
      break;
    
    default:
      $func = 'create_article_card';
      break;
  }

  if ( $_POST['default_class'] === 'author-article-card' ) {
    $func = 'create_author_article_card';
  }

  $args = [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ];

  if ( $_POST['default_class'] ) {
    $args['default_class'] = $_POST['default_class'];
  }

  $response .= $func( $args );
  $response .= $func( $args );
  $response .= $func( $args );
  $response .= $func( $args );
  $response .= $func( $args );
  $response .= $func( $args );

  echo json_encode( $response );

  die();
}

add_action( 'wp_ajax_nopriv_loadmore', 'loadmore' ); 
add_action( 'wp_ajax_loadmore', 'loadmore' );