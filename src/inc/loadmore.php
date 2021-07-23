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

  $response .= $func( [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= $func( [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= $func( [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= $func( [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= $func( [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= $func( [
    'object' => $posts[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );

  echo json_encode( $response );

  die();
}

add_action( 'wp_ajax_nopriv_loadmore', 'loadmore' ); 
add_action( 'wp_ajax_loadmore', 'loadmore' );