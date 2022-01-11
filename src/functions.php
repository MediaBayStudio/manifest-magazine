<?php
// Глобальные переменные
$template_directory_uri = get_template_directory_uri();
$template_directory = get_template_directory();

$upload_dir = wp_get_upload_dir();
$upload_basedir = $upload_dir['basedir'];
$upload_baseurl = $upload_dir['baseurl'] . DIRECTORY_SEPARATOR;

$site_url = site_url();
$ssl = is_ssl();

$address = get_option( 'contacts_address' );
$address_link = get_option( 'contacts_address_link' );
$tel = get_option( 'contacts_tel' );
$tel_adv = get_option( 'contacts_tel_adv' );
$tel_dry = preg_replace( '/\s/', '', $tel );
$tel_adv_dry = preg_replace( '/\s/', '', $tel_adv );
$email = get_option( 'contacts_email' );
$email_adv = get_option( 'contacts_email_adv' );
$facebook_link = get_option( 'contacts_facebook' );
$instagram_link = get_option( 'contacts_instagram' );
$twitter_link = get_option( 'contacts_twitter' );
$telegram_link = get_option( 'contacts_telegram' );

$social_links = [ 
  'instagram' => $instagram_link,
  'telegram' => $telegram_link,
  // 'facebook' => $facebook_link,
  // 'twitter' => $twitter_link
];

$logo_id = get_theme_mod( 'custom_logo' );
$logo_url = wp_get_attachment_url( $logo_id );

// Проверка поддержки webp браузером
$webp_support = strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], ' Chrome/' ) !== false;


// Модицифируем поиск по статьям
add_filter( 'pre_get_posts', function( $query ) {
  if ( $query->is_search && $_GET['s'] === 'category' ) {
    $query->set( 'category__in', $_GET['term_id'] );
    $query->set( 's', '' );
  }
  return $query;
} );

// Модифицируем <title> на странице поиска
add_filter( 'document_title_parts', function( $title ) {
  if ( $_GET['s'] === 'category' ) {
    $term_name = '«' . get_term( $_GET['term_id'] )->name . '»';
    $title['title'] = 'Результаты поиска ' . $term_name;
  }
  return $title;
} );

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

// Добавление своих блоков в гутенберг
require $template_directory . '/inc/gutenberg-blocks.php';

// Склеивание путей с правильным сепаратором
require $template_directory . '/inc/php-path-join.php';

require $template_directory . '/inc/get-excerpt.php';

// Вывод статьи
require $template_directory . '/inc/create-article.php';

// Вывод карточек статей
require $template_directory . '/inc/create-article-card.php';
require $template_directory . '/inc/create-author-article-card.php';

// Вывод карточек вопрос-ответ
require $template_directory . '/inc/create-faq-card.php';

// Подсчет кол-ва просмотров статей
require $template_directory . '/inc/posts-views-count.php';

// Новые колонки в админке
require $template_directory . '/inc/posts-columns.php';

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

  // Добавление спецсимволов html в заголовки и тело статей
  require $template_directory . '/inc/posts-typography.php';

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