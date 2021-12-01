<?php

add_action( 'save_post_post', 'edit_typography' );

function edit_typography( $post_id ) {
  return;
  if ( $parent_id = wp_is_post_revision( $post_id ) ) {
    $post_id = $parent_id;
  }

  $post = get_post( $post_id );

  $post_title = $post->post_title;
  $post_content = $post->post_content;

  if ( $post->post_status !== 'trash' ) {
    // Предлоги
    $reg_exp_nbsp = '/(?<=\s|\()(а|у|и|с|в|на|не|из|вы|до|от)\s/ui';

    // Дефис с пробелом
    $reg_exp_mdash  = '/\s(—|-)(?=\s)/';

    // Кавычки
    $reg_exp_quot = '/(?<!\=)«(?!>)|(?<!\=)»(?!>)|(?<!\=)"(?!>)/';

    // Неразрывный дефис
    $reg_exp_nbh = '/(?<=\w|\d)-(?=\w|\d)/';

    if ( $post_content === '' ) {
      return;
    }

    $post_title = preg_replace( $reg_exp_nbsp, '$1&nbsp;', $post_title );
    $post_title = preg_replace( $reg_exp_mdash, '&nbsp;&mdash;', $post_title );
    $post_title = preg_replace( $reg_exp_quot, '&quot;', $post_title );
    $post_title = preg_replace( $reg_exp_nbh, '&8209;', $post_title );

    $post_content = preg_replace( $reg_exp_nbsp, '$1&nbsp;', $post_content );
    $post_content = preg_replace( $reg_exp_mdash, '&nbsp;&mdash;', $post_content );
    // $post_content = preg_replace( $reg_exp_quot, '&quot;', $post_content );
    $post_content = preg_replace( $reg_exp_nbh, '&#8209;', $post_content );

    remove_action( 'save_post_post', 'edit_typography' );

    wp_update_post( [
      'ID' => $post_id,
      'post_title' => $post_title,
      'post_content' => $post_content,
      'post_status' => 'publish'
    ] );

    add_action( 'save_post_post', 'edit_typography' );
  } //endif $post->post_status !== 'trash'
}