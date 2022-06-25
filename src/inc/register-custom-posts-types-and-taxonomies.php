<?php

add_action( 'init', function() {
  register_post_type( 'author_question', [
    'label'  => null,
    'labels' => [
      'name'               => 'Вопросы эксперту',
      'singular_name'      => 'Вопрос эксперту',
      'add_new'            => 'Добавить',
      'add_new_item'       => 'Добавление',
      'edit_item'          => 'Редактирование',
      'new_item'           => 'Новое ',
      'view_item'          => 'Смотреть',
      'search_items'       => 'Искать',
      'not_found'          => 'Не найдено',
      'not_found_in_trash' => 'Не найдено в корзине',
      'parent_item_colon'  => '',
      'menu_name'          => 'Вопросы эксперту',
    ],
    'description'         => '',
    'public'              => true,
    'show_in_menu'        => null,
    'show_in_rest'        => null,
    'rest_base'           => null,
    'menu_position'       => null,
    'menu_icon'           => null,
    'hierarchical'        => false,
    'supports'            => ['title'],
    'taxonomies'          => ['author_question']
  ] );

  register_post_type( 'inspiration', [
    'label'  => null,
    'labels' => [
      'name'               => 'Вдохновения дня',
      'singular_name'      => 'Вдохновение дня',
      'add_new'            => 'Добавить',
      'add_new_item'       => 'Добавление',
      'edit_item'          => 'Редактирование',
      'new_item'           => 'Новое ',
      'view_item'          => 'Смотреть',
      'search_items'       => 'Искать',
      'not_found'          => 'Не найдено',
      'not_found_in_trash' => 'Не найдено в корзине',
      'parent_item_colon'  => '',
      'menu_name'          => 'Вдохновения дня',
    ],
    'description'         => '',
    'public'              => true,
    'show_in_menu'        => null,
    'show_in_rest'        => null,
    'rest_base'           => null,
    'menu_position'       => null,
    'menu_icon'           => null,
    'hierarchical'        => false,
    'supports'            => ['title']
  ] );

  register_taxonomy( 'author_question_category', ['author_question'], [
    'label'                 => '',
    'labels'                => [
      'name'              => 'Категории',
      'singular_name'     => 'Категория',
      'search_items'      => 'Найти',
      'all_items'         => 'Все',
      'view_item '        => 'Показать',
      'parent_item'       => 'Родитель',
      'parent_item_colon' => 'Родитель:',
      'edit_item'         => 'Изменить',
      'update_item'       => 'Обносить',
      'add_new_item'      => 'Добавить',
      'new_item_name'     => 'Добавить',
      'menu_name'         => 'Категории',
    ],
    'hierarchical'          => true,
    'meta_box_cb'           => false
  ] );

});

