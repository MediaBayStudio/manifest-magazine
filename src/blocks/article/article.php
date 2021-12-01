<?php
$terms = get_the_terms( $post->ID, 'category' );

foreach ( $terms as $term ) {
  if ( !$term->parent ) {
    $parent_category = $term;
    break;
  }
}

create_article( [
  'article' => $post,
  'related_articles' => true,
  'parent_category' => $parent_category
] );