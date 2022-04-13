<?php
  $thumbnail_url = wp_get_attachment_url( $section['avatar']);
  $thumbnail_webp_url = str_replace( ['.jpg', '.png'], '.webp', $thumbnail_url );
?>
<section id="horoscope" class="horoscope-hero sect container">
  <h2 class="contacts-hero-sect__title sect-title sect-title-underline">Eженедельный гороскоп</h2>
  <div class="horoscope-author">
    <div class="horoscope-author__info">
      <picture class="horoscope-author__pic">
        <source type="image/webp" srcset="<?php echo $thumbnail_webp_url ?>">
        <img src="<?php echo $thumbnail_url ?>" alt="<?php echo $section['name'] ?>" class="horoscope-author__img">
      </picture>
      <p class="horoscope-author__name">
        <?php echo $section['name'] ?><br>
        <span>АСТРОЛОГ</span>
      </p>
    </div>
    <p class="horoscope-author__descr"><?php echo $section['descr'] ?></p>
  </div>
</section>