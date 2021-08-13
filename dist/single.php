<?php

/*
	Template name: single
*/

get_header();

set_post_views( $post->ID );

foreach ( $GLOBALS['sections'] as $section ) {
	if ( $section['is_visible'] ) {
		require 'template-parts/' . $section['acf_fc_layout'] . '.php';
	}
}

get_footer();