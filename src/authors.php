<?php

/*
	Template name: authors
*/

get_header();

foreach ( $GLOBALS['sections'] as $section ) {
	require 'template-parts/' . $section['acf_fc_layout'] . '.php';
	if ( is_page_template( 'authors.php' ) && $section['acf_fc_layout'] === 'faq' ) : ?>
		<section class="author-articles-sect sect container">
			<div class="author-articles-sect__articles author-articles author-articles-masonry"> <?php
				$articles = get_posts( [
		    	'numberposts' => 4
		  	] );
				foreach ( $articles as $article ) {
		      create_author_article_card( [
		        'object' => $article,
		        'lazyload' => true
		      ] );
		      
		      create_author_article_card( [
		        'object' => $article,
		        'lazyload' => true
		      ] );

		    } ?>
	  	</div>
	    <button type="button" class="author-articles-sect__loadmore btn loadmore-btn" data-cards-class="author-article-card" data-post-type="post" data-numberposts="6" data-grid-masonry="false" data-posts-count-mobile="4" data-posts-count-desktop="6" data-mobile-media-query="(max-width:767.98px)">Загрузить еще</button>
		</section> <?php
	endif;
}

get_footer();
