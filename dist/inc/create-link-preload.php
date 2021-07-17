<?php

function create_link_preload( $item ) {
  global $template_directory, $webp_support, $media_queries, $site_url;

  $media = '';

  // $type = '';

  if ( is_string( $item ) ) {
    $filepath = $item;
  } else if ( is_array( $item ) ) {
    $img_id = $item['id'];
    $desktop_url = image_get_intermediate_size( $img_id, 'desktop' );
    $laptop_url = image_get_intermediate_size( $img_id, 'laptop' );
    $tablet_url = image_get_intermediate_size( $img_id, 'tablet' );
    $mobile_url = image_get_intermediate_size( $img_id, 'mobile' );
    $webp_url = str_replace( ['.jpg', '.png'], '.webp', $item['url'] );

    if ( $desktop_url ) {
      if ( $webp_support ) {
        $desktop_url = str_replace( ['.jpg', '.png'], '.webp', $desktop_url['url'] );
      } else {
        $desktop_url = $desktop_url['url'];
      }
      $filepaths[] = [
        'path' => $desktop_url,
        'media' => '(min-width:1279.98px)'
      ];
    }

    if ( $laptop_url ) {
      if ( $webp_support ) {
        $laptop_url = str_replace( ['.jpg', '.png'], '.webp', $laptop_url['url'] );
      } else {
        $laptop_url = $laptop_url['url'];
      }
      $filepaths[] = [
        'path' => $laptop_url,
        'media' => '(min-width:767.98px) and (max-width:1023.98px)'
      ];
    }

    if ( $tablet_url ) {
      if ( $webp_support ) {
        $tablet_url = str_replace( ['.jpg', '.png'], '.webp', $tablet_url['url'] );
      } else {
        $tablet_url = $tablet_url['url'];
      }
      $filepaths[] = [
        'path' => $tablet_url,
        'media' => '(min-width:575.98px) and (max-width:767.98px)'
      ];
    }

    if ( $mobile_url ) {
      if ( $webp_support ) {
        $mobile_url = str_replace( ['.jpg', '.png'], '.webp', $mobile_url['url'] );
      } else {
        $mobile_url = $mobile_url['url'];
      }
      $filepaths[] = [
        'path' => $mobile_url,
        'media' => '(max-width:575.98px)'
      ];
    }

    if ( !$filepaths ) {
      if ( $webp_support ) {
        $filepaths[] = [
          'path' => $webp_url
        ];
      } else {
        $filepaths[] = [
          'path' => $item['url']
        ];
      }
    }

  } else {
    if ( $item['filepath'] ) {

      // var_dump( $item );

      if ( $item['upload'] ) {
        $filepath = $item['filepath'];
      } else {
        $filepath = php_path_join( $template_directory, $item['filepath'] );
      } // endif $item['upload']

      // if ( $item['file'] ) {
      //   $type = $item['file']['mime_type'] . '"';
      // } else if ( strpos( $item['filepath'], '.svg' ) !== false ) {
      //   $type = 'image/svg+xml';
      // } else if ( strpos( $item['filepath'], '.webp' ) !== false ) {
      //   $type = 'image/webp';
      // }

      $media = $item['media'] ? ' media="' . $item['media'] . '"' : '';
    } else if ( $item['file'] ) {
      $fields = get_fields( $item['file']['ID'] );

      $fields = [
        '2x_webp' => $fields['2x_webp_i'],
        'webp' => $fields['webp_i'],
        '2x' => $fields['2x_i']
      ];

      if ( $webp_support ) {
        $filepaths[] = [
          'path' => php_path_join( $site_url, $fields['2x_webp'] ),
          'media' => $media_queries['2x'],
          'type' => $item['file']['mime_type']
        ];

        $filepaths[] = [
          'path' => php_path_join( $site_url, $fields['webp'] ),
          'media' => $media_queries['1x'],
          'type' => $item['file']['mime_type']
        ];
      } else {
        $filepaths[] = [
          'path' => php_path_join( $site_url, $fields['2x'] ),
          'media' => $media_queries['2x'],
          'type' => $item['file']['mime_type']
        ];

        $filepaths[] = [
          'path' => $item['file']['url'],
          'media' => $media_queries['1x'],
          'type' => $item['file']['mime_type']
        ]; 
      } // endif $webp_support
    } // endif $item['file']
  } // endif is_string( $item )

  if ( $filepaths ) {
    foreach ( $filepaths as $path ) {
      echo '<link rel="preload" as="image" href="' . $path['path'] . '"' . ( $path['media'] ? ' media="' . $path['media'] . '"' : "" ) . ' />' . PHP_EOL;
    }
  } else {
    echo '<link rel="preload" as="image" href="' . $filepath . '"' . $media . ' />' . PHP_EOL;
  } // endif $filepaths

}