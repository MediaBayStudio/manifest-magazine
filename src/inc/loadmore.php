<?php

function loadmore() {

  $args = [
    'numberposts' => 6,
    'post_type' => $_POST['post_type']
  ];

  $articles = get_posts( $args );

  $response .= create_article_card( [
    'article' => $articles[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= create_article_card( [
    'article' => $articles[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= create_article_card( [
    'article' => $articles[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= create_article_card( [
    'article' => $articles[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= create_article_card( [
    'article' => $articles[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );
  $response .= create_article_card( [
    'article' => $articles[0],
    'lazyload' => false,
    'classes' => ' hide',
    'print' => false
  ] );

  echo json_encode( $response );

  die();
}

add_action( 'wp_ajax_nopriv_loadmore', 'loadmore' ); 
add_action( 'wp_ajax_loadmore', 'loadmore' );