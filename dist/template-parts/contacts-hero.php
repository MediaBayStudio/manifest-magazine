<section class="contacts-hero-sect container"<?php echo $section_id ?>>
  <h1 class="contacts-hero-sect__title sect-h1"><?php echo $section['title'] ?></h1>
  <section class="contacts-hero-sect__contacts contacts">
    <h2 class="contacts__title">Редакция</h2>
    <!-- <div class="contacts__block">
      <span class="contacts__block-title">Адрес редакции</span>
      <a href="<?php #echo $address_link ?>" target="_blank" class="contacts__block-link"><?php #echo $address ?></a>
    </div> -->
    <div class="contacts__block">
      <span class="contacts__block-title">Телефон</span>
      <a href="tel:<?php echo $tel_dry ?>" target="_blank" class="contacts__block-link"><?php echo $tel ?></a>
    </div>
    <div class="contacts__block">
      <span class="contacts__block-title">E-mail</span>
      <a href="mailto:<?php echo $email ?>" target="_blank" class="contacts__block-link"><?php echo $email ?></a>
    </div>
    <div class="contacts__block">
      <span class="contacts__block-title">Мы в социальных сетях</span>
      <div class="contacts__block-socials"> <?php
        foreach ( $social_links as $social_link_title => $social_link_url ) :
          if ( $social_link_url ) : ?>
            <a href="<?php echo $social_link_url ?>" target="_blank" class="contacts__block-socials-link <?php echo $social_link_title ?>"></a> <?php
          endif;
        endforeach ?>
      </div>
    </div>
  </section>
  <section class="contacts-hero-sect__adv contacts">
    <img src="<?php echo $template_directory_uri ?>/img/manifest-blue.svg" alt="manifest" class="contacts-hero-sect__adv-img" width="375" height="155">
    <!-- <h2 class="contacts__title">По вопросам рекламы</h2>
    <div class="contacts__block">
      <span class="contacts__block-title">Телефон</span>
      <a href="tel:<?php #echo $tel_adv_dry ?>" target="_blank" class="contacts__block-link"><?php #echo $tel_adv ?></a>
    </div>
    <div class="contacts__block">
      <span class="contacts__block-title">E-mail</span>
      <a href="mailto:<?php #echo $email_adv ?>" target="_blank" class="contacts__block-link"><?php #echo $email_adv ?></a>
    </div> --> <?php
    #if ( $section['file'] ) : ?>
      <!-- <a href="<?php #echo $section['file'] ?>" download target="_blank" class="contacts__link">Скачать медиакит</a> --> <?php
    #endif ?>
  </section>
</section>