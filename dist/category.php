<?php

/*
	Template name: category
*/

get_header();

foreach ( $GLOBALS['sections'] as $section ) {
	if ( $section['is_visible'] ) {
		require 'template-parts/' . $section['acf_fc_layout'] . '.php';
	}
	if ( $section['acf_fc_layout'] === 'category-articles' ) {
		$articles = get_posts( [
			'numberposts' => 6,
			'offset' => 6,
			'category' => $that->term_id
		] );
		if ( $articles ) : ?>
			<div class="category-hero-articles container sect" data-id="category-hero-sect-2">
			  <div class="gutter-size"></div> <?php
			  $i = 0;
			  $articles_html = '';
			  foreach ( $articles as $article ) {
			    if ( $i === 0 || $i === 4 ) {
			      $classes = ' category-hero-article-card--height2';
			    } else {
			      $classes = '';
			    }
			    $articles_html .= create_article_card( [
			      'object' => $article,
			      'lazyload' => true,
			      'print' => false,
			      'classes' => $classes,
			      'default_class' => 'category-hero-article-card'
			    ] );
			    $i++;
			  }
			  echo $articles_html ?>
			</div> <?php
		endif;
	}
}

get_footer();