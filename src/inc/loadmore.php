<?php

function loadmore() {

  $args = [
    'numberposts' => 6,
    'offset' => $_POST['offset'],
    'post_type' => $_POST['post_type'],
  ];

  if ( $_POST['numberposts'] ) {
    $args['numberposts'] = $_POST['numberposts'];
  }

  if ( $_POST['order'] ) {
    $args['order'] = $_POST['order'];
  }

  if ( $_POST['orderby'] ) {
    $args['orderby'] = $_POST['orderby'];
  }

  if ( $_POST['meta_key'] ) {
    $args['meta_key'] = $_POST['meta_key'];
  }

  if ( $_POST['exclude'] ) {
    $args['exclude'] = $_POST['exclude'];
  }

  if ( $_POST['category'] || $_POST['category'] == 0 ) {
    $args['category'] = $_POST['category'];
    $category = get_term( $args['category'] );
    $posts_count = $args['category'] == 0 ? wp_count_posts()->publish : $category->count;
    $response .= '<div data-posts-count="' . $posts_count . '"></div>';
  }

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

  if ( $_POST['default_class'] ) {
    $args['default_class'] = $_POST['default_class'];
  }

  foreach ( $posts as $post ) {
    $args = [
      'object' => $post,
      'lazyload' => false,
      'classes' => ' hide',
      'print' => false
    ];
    $response .= $func( $args );
  }

  echo json_encode( $response );

  die();
}

add_action( 'wp_ajax_nopriv_loadmore', 'loadmore' ); 
add_action( 'wp_ajax_loadmore', 'loadmore' );