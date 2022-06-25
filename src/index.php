<?php

/*
	Template name: index
*/

get_header();

// $posts = get_posts( [
// 	'numberposts' => -1
// ] );

// foreach ( $posts as $post ) {
// 	if ( stripos( $post->post_content, '&nbsp;' ) !== false ) {
// 		$new_content = str_replace( '&nbsp;', ' ', $post->post_content );
// 		var_dump( wp_update_post( [
// 			'ID' => $post->ID,
// 			'post_content' => $new_content
// 		], true ) );
// 	}
// }

foreach ( $GLOBALS['sections'] as $section ) {
	if ( $section['is_visible'] ) {
		$section_id = $section['id'] ? ' id="' . $section['id'] . '"' : '';
		require 'template-parts/' . $section['acf_fc_layout'] . '.php';
	}
}

get_footer();