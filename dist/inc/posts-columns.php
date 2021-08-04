<?php

function manage_columns( $columns ) {
  $num = 1; // после какой по счету колонки вставлять новые

  $new_columns = [
    'title' => 'Название',
    'views' => 'Просмотры',
    'modified' => 'Дата изменения',
    'date' => 'Дата публикации'
  ];

  return array_slice($columns, 0, $num) + $new_columns + array_slice($columns, $num);
}

function namage_custom_column( $colname, $post_id ) {
  $post_type = get_post_type( $post_id );

  switch ( $colname ) {
    case 'views':
      echo get_post_views( $post_id );
      break;
    case 'title':
      echo '<p>' . get_the_title( $post_id ) . '</p>';
      break;
    case 'modified':
      echo '<p>Изменено<br>' . get_the_modified_date( 'd.m.Y, G:i' ) . '</p>';
      break;
  }
}

// Создание новых колонок
add_filter( 'manage_post_posts_columns', 'manage_columns', 4 );

// Заполнение колонок нужными данными
add_action( 'manage_post_posts_custom_column', 'namage_custom_column', 5, 2);