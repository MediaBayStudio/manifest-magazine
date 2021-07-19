<?php
// Глобальные переменные
$template_directory_uri = get_template_directory_uri();
$template_directory = get_template_directory();
$site_url = site_url();
$ssl = is_ssl();

// $address = get_option( 'contacts_address' );
// $tel = get_option( 'contacts_tel' );
// $tel_dry = preg_replace( '/\s/', '', $tel );
// $email = get_option( 'contacts_email' );
// $insta = get_option( 'contacts_insta' );

$logo_id = get_theme_mod( 'custom_logo' );
$logo_url = wp_get_attachment_url( $logo_id );

// Проверка поддержки webp браузером
$webp_support = strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], ' Chrome/' ) !== false;

// $media = [
  // '1x_webkit' => '(-webkit-max-device-pixel-ratio:1.99)',
  // '1x_ie' => '(max-resolution: 191.04dpi)',
  // '2x_webkit' => '(-webkit-min-device-pixel-ratio:2)',
  // '2x_ie' => '(min-resolution: 192dpi)',
  // 'maw576' => '(max-width:575.98px)',
  // 'miw576' => '(min-width:575.98px)',
  // 'maw768' => '(max-width:767.98px)',
  // 'miw768' => '(min-width:767.98px)',
  // 'maw1024' => '(max-width:1023.98px)',
  // 'miw1024' => '(min-width:1023.98px)'
// ];

// Передаем в js некоторые данные о сайте
add_action( 'admin_head', 'print_site_data' );
add_action( 'wp_body_open', 'print_site_data' );

function path_to_url( $path ) {
  global $ssl;

  $protocol = $ssl ? 'https://' : 'http://';
  $cut = '/Applications/MAMP/htdocs';
  $url = $protocol . $_SERVER['HTTP_HOST'];

  return str_replace( $cut, $url, $path );
}

function print_site_data() {
  global $site_url, $template_directory_uri, $template_directory;
  echo '<script id="page-data">var siteUrl = "' . $site_url . '", templateDirectoryUri = "' . $template_directory_uri . '", templateDirectory = "' . $template_directory . '"</script>';
}

// Запрет обновления плагинов
add_filter( 'site_transient_update_plugins', function( $value ) {
  unset(
    $value->response['contact-form-7/wp-contact-form-7.php'],
    $value->response['contact-form-7-honeypot/honeypot.php'],
    $value->response['advanced-custom-fields-pro/acf.php']
  );

  return $value;
} );

add_filter( 'template_include', function( $template ) {
  global $post;
  
  $GLOBALS['current_template'] = pathinfo( $template )['filename'];

  if ( $post->post_type === 'page' ) {
    $page_template_id = $post->ID;
  } else {
    $page = get_pages( [
      'meta_key' => '_wp_page_template',
      'meta_value' => $GLOBALS['current_template'] . '.php'
    ] )[0];

    $page_template_id = $page->ID;
  }

  $GLOBALS['sections'] = get_field( 'sections', $page_template_id );
  return $template;
} );

// Склеивание путей с правильным сепаратором
require $template_directory . '/inc/php-path-join.php';

// Вывод карточек статей
require $template_directory . '/inc/create-article-card.php';
require $template_directory . '/inc/create-author-article-card.php';

// Подсчет кол-ва просмотров статей
require $template_directory . '/inc/posts-views-count.php';

// loadmore
require $template_directory . '/inc/loadmore.php';

// Нарезание изображений, создание webp
require $template_directory . '/inc/generate-images.php';

// Создание <picture> для img
// require $template_directory . '/inc/create-picture.php';

// Создание <link rel="preload" /> для img
require $template_directory . '/inc/create-link-preload.php';

// Активация SVG и WebP в админке
require $template_directory . '/inc/enable-svg-and-webp.php';

// Регистрация стилей и скриптов для страниц и прочие манипуляции с ними
require $template_directory . '/inc/enqueue-styles-and-scripts.php';

// Отключение стандартных скриптов и стилей, гутенберга, emoji и т.п.
require $template_directory . '/inc/disable-wp-scripts-and-styles.php';

// Регистрация меню на сайте
require $template_directory . '/inc/menus.php';

// Регистрация доп. полей в меню Настройки->Общее
require $template_directory . '/inc/options-fields.php';

// Регистрация и изменение записей и таксономий
require $template_directory . '/inc/register-custom-posts-types-and-taxonomies.php';

// Нужные поддержки темой, рамзеры для нарезки изображений
require $template_directory . '/inc/theme-support-and-thumbnails.php';


if ( is_super_admin() || is_admin_bar_showing() ) {

	// Функция формирования стилей для страницы при сохранении страницы
	require $template_directory . '/inc/build-styles.php';

	// Функция формирования скриптов для страницы при сохранении страницы
	require $template_directory . '/inc/build-scripts.php';

	// Функция создания webp для изображений
	// require $template_directory . '/inc/create-images.php';

	// Формирование файла pages-info.json, для понимания на какой странице какие секции используются
	require $template_directory . '/inc/build-pages-info.php';

	// Удаление лишних пунктов из меню админ-панели и прочие настройки админ-панели
	require $template_directory . '/inc/admin-menu-actions.php';


}