<?php

$GLOBALS['quired_object'] = get_queried_object();
$that = $GLOBALS['quired_object'];

$section_title = $section['title_is_full'] ? get_field( 'full_title', $that ) : $that->name;

$term_args = [
  'taxonomy' => 'category',
  'hide_empty' => false
];

$parent = $that->parent;

if ( $parent ) {
  $parent_term = get_term( $parent );
  $term_args['parent'] = $parent;
  $active_term_id = $that->term_id;
  $section_title = $section['title_is_full'] ? get_field( 'full_title', $parent_term ) : $parent_term->name;
} else {
  $term_args['child_of'] = $that->term_id;
  $active_term_id = 0;
}

$child_categories = $section['child_categories_manually'] ? $section['child_categories'] : get_terms( $term_args );

array_unshift( $child_categories, (object)[
  'name' => 'Все темы',
  'term_id' => 0
] ) ?>

<section class="category-hero-sect container"<?php echo $section_id ?>>
  <h1 class="category-hero-sect__title sect-h1"><?php echo $section_title ?></h1>
  <ul class="category-hero-sect__menu category-hero-menu"> <?php
    foreach ( $child_categories as $child_category ) : ?>
      <li class="category-hero-menu__li<?php echo ( $child_category->term_id == $active_term_id ) ? ' active' : '' ?>"><button type="button" class="category-hero-menu__btn" data-category-id="<?php echo $child_category->term_id ?>"><?php echo $child_category->name ?></button></li><li class="category-hero-menu__dot"></li> <?php
    endforeach ?>
  </ul>
</section>

<?php 

$article = get_post( 145 );

$articles = array_fill( 0, 6, $article );

 ?>

<div class="category-hero-articles container sect" data-id="category-hero-sect-1">
  <div class="gutter-size"></div> <?php
  $i = 0;
  // $articles_html = '';
  foreach ( $articles as $article ) {
    if ( $i === 0 || $i === 4 ) {
      $classes = ' category-hero-article-card--height2';
    //   $articles_html .= '<div class="category-hero-articles__articles">';
    } else {
      $classes = '';
    }
    $articles_html .= create_article_card( [
      'article' => $article,
      'lazyload' => true,
      'print' => false,
      'classes' => $classes,
      'default_class' => 'category-hero-article-card'
    ] );
    // if ( $i === 2 || ($i + 1) % 3 === 0 ) {
      // $articles_html .= '</div>';
    // }
    $i++;
  }
  echo $articles_html ?>
  
</div>