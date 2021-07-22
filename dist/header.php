<?php
  global
    $instagram_link,
    $facebook_link,
    $twitter_link,
    $preload,
    $site_url,
    $logo_url,
    $template_directory_uri;

    if ( is_front_page() ) {
      $script_name = 'script-index';
      $style_name = 'style-index';
    } else {
      if ( $GLOBALS['current_template'] ) {
        $script_name = 'script-' . $GLOBALS['current_template'];
        $style_name = 'style-' . $GLOBALS['current_template'];
      } else {
        $script_name = '';
        $style_name = '';
      } 
    }

    if ( is_author() ) {
      $GLOBALS['current_author'] = get_queried_object();
      $GLOBALS['current_author']->avatar_url = get_field( 'avatar', $GLOBALS['current_author'] )['url'];
      $GLOBALS['current_author']->avatar_webp_url = str_replace( ['.jpg', '.png'], '.webp', $GLOBALS['current_author']->avatar_url );
    }

    $GLOBALS['page_script_name'] = $script_name;
    $GLOBALS['page_style_name'] = $style_name ?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=CustomEvent%2CIntersectionObserver%2CIntersectionObserverEntry%2CElement.prototype.closest%2CElement.prototype.dataset%2CHTMLPictureElement"></script>
  <meta charset="<?php bloginfo( 'charset' ) ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <!-- styles preload -->
  <link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/style.css"> <?php
  if ( $style_name ) : ?>
	<link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/<?php echo $style_name ?>.css" />
	<link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/<?php echo $style_name ?>.576.css" media="(min-width:575.98px)" />
	<link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/<?php echo $style_name ?>.768.css" media="(min-width:767.98px)" />
	<link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/<?php echo $style_name ?>.1024.css" media="(min-width:1023.98px)" />
	<link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/<?php echo $style_name ?>.1280.css" media="(min-width:1279.98px)" /> <?php
  endif ?>
  <link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/hover.css" media="(hover) and (min-width:1024px)" />
  <!-- fonts preload --> <?php
	$fonts = [
		'QuincyCF-Bold.woff',
		'Raleway-Regular.woff',
		'SegoeUI-SemiBold.woff'
	];
	foreach ( $fonts as $font ) : ?>

	<link rel="preload" href="<?php echo $template_directory_uri . '/fonts/' . $font ?>" as="font" type="font/woff" crossorigin="anonymous" /> <?php
	endforeach ?>
  <!-- other preload --> <?php
  echo PHP_EOL;
  if ( !$preload ) {
    $preload = get_field( 'preload' );
  }

  $preload[] = $logo_url;
  $preload[] = $template_directory_uri . '/img/icon-burger.svg';
  $preload[] = $template_directory_uri . '/img/icon-search.svg';

  if ( is_front_page() ) {
    if ( $GLOBALS['sections'][0]['slider_view'] === 'smaill_img' ) {
      $preload[] = $GLOBALS['sections'][0]['slider'][0]['small_img'];
      $preload[] = $template_directory_uri . '/img/words-circle.svg';
      $preload[] = $template_directory_uri . '/img/index-hero-line.svg';
    } else {
      $preload[] = $GLOBALS['sections'][0]['slider'][0]['full_screen_img'];
    }
  }


  if ( is_author() ) {

    $preload[] = [
      'filepath' => $GLOBALS['current_author']->avatar_url,
      'webp' => $GLOBALS['current_author']->avatar_webp_url
    ];
    $preload[] = [
      'filepath' => $template_directory_uri . '/img/author-hero-bg-mobile.svg',
      'media' => '(max-width:767.98px)'
    ];
    $preload[] = [
      'filepath' => $template_directory_uri . '/img/author-hero-bg-desktop.svg',
      'media' => '(min-width:767.98px)'
    ];
  }

  if ( $preload ) {
    foreach ( $preload as $item ) {
      create_link_preload( $item );
    }
    unset( $item );
    echo PHP_EOL;
  } ?>
  <!-- favicons --> <?php
  echo PHP_EOL;
  wp_head() ?>
</head>

<body <?php body_class() ?>> <?php
  wp_body_open() ?>
  <noscript>
    <!-- <noindex> -->Для полноценного использования сайта включите JavaScript в настройках вашего браузера.<!-- </noindex> -->
  </noscript>
  <div id="page-wrapper"> <?php
    if ( is_front_page() ) : ?>
      <h1 class="visually-hidden"><?php bloginfo( 'name' ) ?> &mdash; <?php bloginfo( 'description' ) ?></h1> <?php
    endif ?>
    <header class="hdr container">
      <button type="button" class="hdr__burger"></button> 
      <a href="<?php echo $site_url ?>" class="hdr__logo">
        <img src="<?php echo $logo_url ?>" alt="Логотип" class="hdr__logo-img">
      </a>
      <button type="button" class="hdr__search"></button> <?php
      wp_nav_menu( [
        'theme_location'  => 'header_menu',
        'container'       => 'nav',
        'container_class' => 'hdr__nav',
        'menu_class'      => 'hdr__nav-list',
        'items_wrap'      => '<ul class="%2$s">%3$s</ul>'
      ] );
      require 'template-parts/mobile-menu.php' ?>
    </header>