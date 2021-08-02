<?php

$image_sizes = [
  'desktop' => 1200,
  'laptop' => 980,
  'tablet' => 740,
  'mobile' => 576,
  // 'author_articles' => [300, 400],
  'thumb' => 400,
];

foreach ( $image_sizes as $size_name => $width ) {
  if ( is_array( $width ) ) {
    $height = $width[1];
    $width = $width[0];
  } else {
    $height = 0;
  }
  add_image_size( $size_name, $width, $height, true );
}

add_action( 'wp_generate_attachment_metadata', function ( $image_meta, $img_id ) {
  global $image_sizes;

  $img_path = get_attached_file( $img_id );
  $img_pathinfo = pathinfo( $img_path );
  $dirname = $img_pathinfo['dirname'];

  foreach ( $image_sizes as $size_name => $width ) {
    $file = image_get_intermediate_size( $img_id, $size_name );
    $file_webp = str_replace( ['.jpg', '.jpeg', '.png'], '', $file['file'] );

    $cwebp = '/usr/local/bin/cwebp -q 90 ' . $file['file'] . ' -o ' . $file_webp . '.webp';

    chdir( $dirname );
    exec( $cwebp );
  }


  $cwebp = '/usr/local/bin/cwebp -q 90 ' . $img_pathinfo['basename'] . ' -o ' . $img_pathinfo['filename'] . '.webp';

  chdir( $dirname );
  exec( $cwebp );
  minifyImg( $img_path );

  return $image_meta;
}, 10, 3 );

add_action( 'delete_attachment', function( $img_id, $img ) {
  global $image_sizes;

  $img_path = get_attached_file( $img_id );
  $img_pathinfo = pathinfo( $img_path );
  $dirname = $img_pathinfo['dirname'];

  foreach ( $image_sizes as $size_name => $width ) {
    $file = image_get_intermediate_size( $img_id, $size_name );
    $file_webp = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $file['file'] );
    $webp_path = $dirname . DIRECTORY_SEPARATOR . $file['file'];
    if ( file_exists( $webp_path ) ) {
      unlink( $webp_path );
    }
  }

}, 10, 2 );


function minifyImg( $src, $dest = null, $quality = 90 ) {
  if ( is_null( $dest ) ) {
    $dest = $src;
  }

  $info = getimagesize( $src );

  if ( $info['mime'] === 'image/jpeg' ) {
    $image = imagecreatefromjpeg( $src );
    $is_jpg = true;
  } elseif ( $info['mime'] === 'image/gif' ) {
    $image = imagecreatefromgif( $src );
  } elseif ( $info['mime'] === 'image/png' ) {
    $is_png = true;
    $image = imagecreatefrompng( $src );
  }

  if ( $is_jpg ) {
    imagejpeg( $image, $dest, $quality );
  } else if ( $is_png ) {
    imagepng( $image, $dest, $quality );
  }

  return $dest;
}
