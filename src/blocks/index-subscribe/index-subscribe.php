<section class="index-subscribe-sect sect-beige-bg container lazy"<?php echo $section_id ?> data-src="#">
  <h2 class="index-subscribe-sect__title sect-title"><?php echo $section['title'] ?></h2>
  <div class="index-subscribe-sect__form-wrap"> <?php
    echo do_shortcode( '[contact-form-7 id="' . $section['form']->ID . '" html_class="index-subscribe-sect__form" html_id="subscribe-form"]' ) ?>
    <button form="subscribe-form" class="index-subscribe-sect__btn btn"><?php echo $section['btn_text'] ?></button>
  </div>
</section>