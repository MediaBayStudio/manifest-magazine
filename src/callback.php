<?php

/*
	Template name: callback
*/

get_header();

foreach ( $GLOBALS['sections'] as $section ) {
	if ( $section['is_visible'] ) {
		require 'template-parts/' . $section['acf_fc_layout'] . '.php';
	}
}

get_footer();