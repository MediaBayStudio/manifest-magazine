<?php
 /* Настройка контактов в панели настройки->общее */
// Функции вывода нужных полей
  function options_inp_html ( $id ) {
    echo "<input type='text' name='{$id}' value='" . esc_attr( get_option( $id ) ) . "'>";
  }

  add_action( 'admin_init', function() {
    $options = [
      'tel'     =>  'Телефон',
      'address' =>  'Адрес редакции',
      'address_link' =>  'Ссылка на адрес (для карт)',
      'email'   =>  'E-mail редакции',
      'email_adv' => 'E-mail по вопросам рекламы',
      'tel' => 'Телефон редакции',
      'tel_adv' => 'Телефон по вопросам рекламы',
      'instagram'    =>  'Ссылка на Instagram',
      'facebook'    =>  'Ссылка на Facebook',
      'twitter'    =>  'Ссылка на Twitter',
      'telegram'    =>  'Ссылка на Telegram'
    ];

    foreach ($options as $id => $name) {
      $my_id = "contacts_{$id}";

      add_settings_field( $id, $name, 'options_inp_html', 'general', 'default', $my_id );
      register_setting( 'general', $my_id );
    }
  } );
