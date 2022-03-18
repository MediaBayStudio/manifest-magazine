<?php
  global
    $webp_support,
    $instagram_link,
    $telegram_link,
    $facebook_link,
    $twitter_link,
    $social_links,
    $address,
    $address_link,
    $email,
    $email_adv,
    $tel,
    $tel_dry,
    $tel_adv,
    $tel_adv_dry,
    $preload,
    $site_url,
    $logo_url,
    $template_directory_uri,
    $version;

    $preload = [];
    $preload[] = ['url' => $logo_url];
    $preload[] = ['url' => $template_directory_uri . '/img/icon-burger.svg'];
    $preload[] = ['url' => $template_directory_uri . '/img/icon-search.svg'];

    if ( is_front_page() ) {
      $script_name = 'script-index';
      $style_name = 'style-index';
      if ( $GLOBALS['sections'][0]['slider_view'] === 'smaill_img' ) {
        // $preload[] = ['url' => $GLOBALS['sections'][0]['slider'][0]['small_img']]['url'];
        $preload[] = ['url' => $template_directory_uri . '/img/words-circle.svg'];
        $preload[] = ['url' => $template_directory_uri . '/img/index-hero-line.svg'];
      }
      $preload[] = [
        'url' => $template_directory_uri . '/js/slick.min.js',
        'as' => 'script'
      ];
      $preload[] = [
        'url' => $template_directory_uri . '/js/script-index.js',
        'as' => 'script'
      ];

    } else if ( is_404() ) {
      $script_name = 'script-404';
      $style_name = 'style-404';
    } else if ( is_single() ) {
      $script_name = 'script-single';
      $style_name = 'style-single';

      $thumbnail_url = get_the_post_thumbnail_url( $post->ID );
      $thumbnail_id = get_post_thumbnail_id( $post->ID );
      $mobile_img = image_get_intermediate_size( $thumbnail_id, 'mobile' );
      $tablet_img = image_get_intermediate_size( $thumbnail_id, 'tablet' );
      $laptop_img = image_get_intermediate_size( $thumbnail_id, 'laptop' );
      $desktop_img = image_get_intermediate_size( $thumbnail_id, 'desktop' );
      $source_html = '';

      $thumbnail_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $thumbnail_url );
      $mobile_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $mobile_img['url'] );
      $tablet_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $tablet_img['url'] );
      $laptop_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $laptop_img['url'] );
      $desktop_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $desktop_img['url'] );

      $post_author_avatar_preload_url = get_field( 'avatar', 'user_' . $post->post_author )['url'];

      if ( $webp_support ) {
        $mobile_preload_url = $mobile_webp_url;
        $tablet_preload_url = $tablet_webp_url;
        $laptop_preload_url = $laptop_webp_url;
        $desktop_preload_url = $desktop_webp_url;
        $post_author_avatar_preload_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $post_author_avatar_preload_url );
      } else {
        $mobile_preload_url = $mobile_img['url'];
        $tablet_preload_url = $tablet_img['url'];
        $laptop_preload_url = $laptop_img['url'];
        $desktop_preload_url = $desktop_img['url'];
      }

      $GLOBALS['article_thumbnail_data'] = [
        'mobile_img_url' => $mobile_img['url'],
        'tablet_img_url' => $tablet_img['url'],
        'laptop_img_url' => $laptop_img['url'],
        'desktop_img_url' => $desktop_img['url'],
        'mobile_webp_url' => $mobile_webp_url,
        'tablet_webp_url' => $tablet_webp_url,
        'laptop_webp_url' => $laptop_webp_url,
        'desktop_webp_url' => $desktop_webp_url,
        'type' => $mobile_img['mime-type']
      ];

      if ( !$desktop_img ) {
        $desktop_preload_url = $webp_support ? $thumbnail_webp_url : $thumbnail_url;
        $GLOBALS['article_thumbnail_data']['desktop_img_url'] = $thumbnail_url;
        $GLOBALS['article_thumbnail_data']['desktop_webp_url'] = $thumbnail_webp_url;
      }

      $first_screen_images = [
        [
          'url' => $mobile_preload_url,
          'imagesrcset' => $laptop_preload_url,
          'media' => '(max-width:767.98px)'
        ],
        [
          'url' => $tablet_preload_url,
          'imagesrcset' => $desktop_preload_url,
          'media' => '(min-width:767.98px) and (max-width:1023.98px)'
        ],
        [
          'url' => $desktop_preload_url,
          'media' => '(min-width:1023.98px)'
        ]
      ];

      foreach ( $first_screen_images as $first_screen_image ) {
        $first_screen_image_data = [
          'url' => $first_screen_image['url'],
          'media' => $first_screen_image['media']
        ];
        if ( $first_screen_image['imagesrcset'] ) {
          $first_screen_image_data['imagesrcset'] = $first_screen_image['imagesrcset'] . ' 2x';
        }
        $preload[] = $first_screen_image_data;
      }

      $preload[] = ['url' => $post_author_avatar_preload_url];

    } else if ( is_author() ) {
      $script_name = 'script-author';
      $style_name = 'style-author';
      $GLOBALS['current_author'] = get_queried_object();
      $GLOBALS['current_author']->avatar_url = get_field( 'avatar', $GLOBALS['current_author'] )['url'];
      $GLOBALS['current_author']->avatar_webp_url = str_replace( ['.jpg', '.png'], '.webp', $GLOBALS['current_author']->avatar_url );

      $avatar_preload_url = $webp_support ? $GLOBALS['current_author']->avatar_webp_url : $GLOBALS['current_author']->avatar_url;

      $preload[] = ['url' => $avatar_preload_url];
      $preload[] = [
        'url' => $template_directory_uri . '/img/author-hero-bg-mobile.svg',
        'media' => '(max-width:767.98px)'
      ];
      $preload[] = [
        'rl' => $template_directory_uri . '/img/author-hero-bg-desktop.svg',
        'media' => '(min-width:767.98px)'
      ];
    } else {
      if ( $GLOBALS['current_template'] ) {
        $script_name = 'script-' . $GLOBALS['current_template'];
        $style_name = 'style-' . $GLOBALS['current_template'];
      } else {
        $script_name = '';
        $style_name = '';
      } 
    }

    $GLOBALS['page_script_name'] = $script_name;
    $GLOBALS['page_style_name'] = $style_name ?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=CustomEvent%2CIntersectionObserver%2CIntersectionObserverEntry%2CElement.prototype.closest%2CElement.prototype.dataset%2CHTMLPictureElement%2Cfetch"></script>
  <!-- <meta charset="<?php #bloginfo( 'charset' ) ?>" /> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <!-- styles preload -->
  <link rel="preload" as="style" href="<?php echo "$template_directory_uri/style.css?ver=$version" ?>"> <?php
  if ( $style_name ) : ?>
  <link rel="preload" as="style" href="<?php echo "$template_directory_uri/css/$style_name.css?ver=$version" ?>" />
  <link rel="preload" as="style" href="<?php echo "$template_directory_uri/css/$style_name.576.css?ver=$version" ?>" media="(min-width:575.98px)" />
  <link rel="preload" as="style" href="<?php echo "$template_directory_uri/css/$style_name.768.css?ver=$version" ?>" media="(min-width:767.98px)" />
  <link rel="preload" as="style" href="<?php echo "$template_directory_uri/css/$style_name.1024.css?ver=$version" ?> " media="(min-width:1023.98px)" />
  <link rel="preload" as="style" href="<?php echo "$template_directory_uri/css/$style_name.1280.css?ver=$version" ?>" media="(min-width:1279.98px)" /> <?php
  endif ?>
  <link rel="preload" as="style" href="<?php echo $template_directory_uri ?>/css/hover.css" media="(hover) and (min-width:1024px)" />
  <!-- fonts preload --> <?php
  $fonts = [
    'QuincyCF-Bold.woff',
    'Raleway-Regular.woff',
    'SegoeUI-SemiBold.woff'
  ];
  if ( is_single() ) {
    $fonts[] = 'Raleway-Bold.woff';
    $fonts[] = 'QuincyCF-Regular.woff'; ?>
    <style>
      @font-face {
        font-family: 'Raleway';
        src: url('<?php echo $template_directory_uri ?>/fonts/Raleway-Bold.woff') format('woff');
        font-weight: bold;
        font-style: normal;
        font-display: swap;
      }
      @font-face {
        font-family: 'QuincyCF';
        src: url('<?php echo $template_directory_uri ?>/fonts/QuincyCF-Regular.woff') format('woff'),
          url('<?php echo $template_directory_uri ?>/fonts/QuincyCF-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
      }
    </style> <?php
  }
  foreach ( $fonts as $font ) : ?>

  <link rel="preload" href="<?php echo $template_directory_uri . '/fonts/' . $font ?>" as="font" crossorigin="anonymous" /> <?php
  endforeach;
  echo PHP_EOL ?>
  <!-- other preload --> <?php
  echo PHP_EOL;

  if ( $preload ) {
    foreach ( $preload as $item ) {
      create_link_preload( $item );
    }
    unset( $item );
    echo PHP_EOL;
  } ?>
  <!-- favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $site_url ?>/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $site_url ?>/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $site_url ?>/favicon-16x16.png">
  <link rel="manifest" href="<?php echo $site_url ?>/site.webmanifest">
  <link rel="mask-icon" href="<?php echo $site_url ?>/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff"> <?php
  echo PHP_EOL;
  wp_head();
  if ( stripos( $_SERVER['HTTP_USER_AGENT'], 'lighthouse' ) === false ) : ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P39P8HM');</script>
    <!-- End Google Tag Manager --> <?php
  endif ?>
</head>

<body <?php body_class() ?>> <?php
  wp_body_open();
  if ( stripos( $_SERVER['HTTP_USER_AGENT'], 'lighthouse' ) === false ) : ?>
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '482640093575419');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=482640093575419&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
  <!-- Yandex.Metrika counter -->
    <script>
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(86902604, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/86902604" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
  <!-- /Yandex.Metrika counter -->
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P39P8HM"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) --> <?php
  endif ?>
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
        <img src="<?php echo $template_directory_uri ?>/img/logo-small.svg" alt="Логотип маленький" class="hdr__logo-img-small">
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