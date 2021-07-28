<section class="about-concept sect container"<?php echo $section_id ?>>
  <h2 class="about-concept__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="about-concept__text">
    <div class="about-concept__text-left">
      <p class="about-concept__descr"><?php echo $section['p_repeater'][0]['p'] ?></p>
      <p class="about-concept__descr"><?php echo $section['p_repeater'][1]['p'] ?></p>
    </div>
    <div class="about-concept__text-right">
      <p class="about-concept__descr"><?php echo $section['p_repeater'][2]['p'] ?></p>
      <p class="about-concept__descr"><?php echo $section['p_repeater'][3]['p'] ?></p>
      <p class="about-concept__descr"><?php echo $section['p_repeater'][4]['p'] ?></p>
    </div>
  </div>
  <div class="about-concept__links lazy lazyloaded" data-src="#">
    <span class="about-concept__links-title">присоединяйтесь к нам в соцсетях</span>
    <a href="<?php echo $instagram_link ?>" target="_blank" class="about-concept__link instagram"></a>
    <a href="<?php echo $facebook_link ?>" target="_blank" class="about-concept__link facebook"></a>
    <a href="<?php echo $twitter_link ?>" target="_blank" class="about-concept__link twitter"></a>
  </div>
</section>