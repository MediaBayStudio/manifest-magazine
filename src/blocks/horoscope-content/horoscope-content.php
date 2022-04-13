<?php
  // названия полей такие же как и у иконок
  $horoscope_info = [
    'oven' => 'Овен',
    'telec' => 'Телец',
    'blizneczy' => 'Близнецы',
    'rak' => 'Рак',
    'lev' => 'Лев',
    'deva' => 'Дева',
    'vesy' => 'Весы',
    'skorpion' => 'Скорпион',
    'strelecz' => 'Стрелец',
    'ryby' => 'Рыбы',
    'vodolej' => 'Водолей',
    'kozerog' => 'Козерог',
  ];

  $date = $section['date'];
?>

<section class="horoscope-content sect container">
  <h2 class="horoscope-m-title"><?php echo $date ?></h2>
  <ul class="horoscope-zodiac-list"> <?php
    foreach ( $horoscope_info as $field_name => $ru_name ) : ?>
      <li class="zodiac-btn<?php echo $field_name === 'oven' ? ' active' : '' ?>" data-zodiac-name="<?php echo $ru_name ?>" data-horoscope-text="<?php echo $section[ $field_name ] ?>">
        <img src="<?php echo "$template_directory_uri/img/icon-zodiac-$field_name.svg" ?>" class="zodiac-btn__icon" alt="<?php echo $ru_name ?>">
        <span class="zodiac-btn__name"><?php echo $ru_name ?></span>
      </li> <?php
    endforeach ?>
  </ul>
  <div class="horoscope-text">
    <p class="horoscope-d-title"><?php echo $date ?></p>
    <span class="horoscope-text__zodiac"><?php echo $horoscope_info['oven'] ?></span>
    <p class="horoscope-text__descr"><?php echo $section['oven'] ?></p>
  </div>
</section>