<section class="contacts-contact-us-sect container lazy"<?php echo $section_id ?> data-src="#">
  <h2 class="contacts-contact-us-sect__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="contacts-contact-us__wrap-form"> <?php
    echo do_shortcode( '[contact-form-7 id="' . $section['form'] . '" html_class="contacts-contact-us__form" html_id="contact-us-form"]' ) ?>
  </div>
</section>