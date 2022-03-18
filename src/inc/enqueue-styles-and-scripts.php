<?php

// Скрипт и стиль в админку
add_action( 'admin_enqueue_scripts', function() {
  global $template_directory_uri, $version;
  wp_enqueue_script( "script-admin", $template_directory_uri . "/js/script-admin.js", [], $version );
  wp_enqueue_style( "style-admin", $template_directory_uri . "/style-admin.css", [], $version );
} );

// Функция подключения стилей
function enqueue_style( $style_name, $widths ) {
  global $template_directory_uri, $version;

  if ( is_string( $widths ) ) {
    if ( $style_name === 'hover' ) {
      wp_enqueue_style( "{$style_name}", $template_directory_uri . "/css/{$style_name}.css", [], $version, "(hover) and (min-width:1024px)" );
    } else {
      wp_enqueue_style( "{$style_name}", $template_directory_uri . "/css/{$style_name}.css", [], $version );
    }
  } else {
    foreach ( $widths as $width ) {
      if ( $width !== "0" ) {
        $media = $width - 0.02;
         // если размер файла равен 0, то не подключаем его
        if ( filesize( get_template_directory_uri() . '/css/' . $style_name . '.' . $width . '.css' ) === 0 ) {
          continue;
        }
        wp_enqueue_style( "{$style_name}-{$width}px", $template_directory_uri . "/css/{$style_name}.{$width}.css", [], $version, "(min-width: {$media}px)" );
      } else {
        wp_enqueue_style( "{$style_name}-page", $template_directory_uri . "/css/{$style_name}.css", [], $version );
      }
    }
  }
}

// Подключаем свои стили и скрипты
add_action( 'wp_enqueue_scripts', function() {
  global $template_directory_uri, $version;
  $screen_widths = ['0', '576', '768', '1024', '1280']; // на каких экранах подключать css

  wp_enqueue_style( 'theme-style', get_stylesheet_uri(), [], $version );        // подключить стиль темы (default)

  // подключаем стили с помощью своей функции
  // enqueue_style( 'style', $screen_widths );

	enqueue_style( $GLOBALS['page_style_name'], $screen_widths );

  enqueue_style( 'hover', '' ); // подключаем стили для эффектов при наведении

  // Подключаем скрипты циклом
  

	$scripts = ['lazy.min', 'lax.min', 'masonry.pkgd.min', 'tail.select.min', 'Popup.min', 'slick.min', 'script', $GLOBALS['page_script_name']];

  foreach ( $scripts as $script ) {
    wp_enqueue_script( "{$script}", $template_directory_uri . "/js/{$script}.js", [], $version );
  }

  // Отключаем стандартные jquery, jquery-migrate
  // лучше подключать свой jquery
  wp_deregister_script( 'jquery-core' );
  wp_deregister_script( 'jquery' );

  // Подключаем свой jquery
  wp_register_script( 'jquery-core', $template_directory_uri . '/js/jquery-3.5.1.min.js', false, null, true );
  wp_register_script( 'jquery', false, ['jquery-core'], null, true );
  wp_enqueue_script( 'jquery' );

} );

// Убираем id и type в тегах script, добавляем нужным атрибут defer
  add_filter( 'script_loader_tag',   function( $html, $handle ) {
    switch ( $handle ) {
      case 'masonry.pkgd.min':
      case 'tail.select.min':
      case 'lazy.min':
      case 'Popup.min':
      case 'slick.min':
      case 'lax.min':
      case 'script':
      case $GLOBALS['page_script_name']:
      case 'contact-form-7':
        $html = str_replace( ' src', ' defer src', $html );
        break;
    }

    $html = str_replace( " id='$handle-js' ", '', $html );
    $html = str_replace( " type='text/javascript'", '', $html );

     return $html;
  }, 10, 2);

// Убираем id и type в тегах style
  add_filter( 'style_loader_tag', function( $html, $handle ) {
    // Подключаем стили гутенберга только в админке
    // if ( !is_single() && !is_admin() && $handle === 'wp-block-library' ) {
      // return '';
    // }
    if ( $handle === 'wp-block-library' ) {
      // return '';
    }
    $html = str_replace( " id='$handle-css' ", '', $html );
    $html = str_replace( " type='text/css'", '', $html );
    return $html;
  }, 10, 2 );