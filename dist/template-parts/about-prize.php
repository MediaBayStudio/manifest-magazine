<section class="about-prize sect container"<?php echo $section_id ?>>
  <img src="#" alt="#" data-src="<?php echo $template_directory_uri ?>/img/decor-star-ol-beige.svg" class="about-prize__decor-star-ol-beige lazy">
  <h2 class="about-prize__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="about-prize__text">
    <div class="about-prize__decor-ring"></div>
    <img src="#" alt="#" data-src="<?php echo $template_directory_uri ?>/img/decor-star-beige.svg" class="about-prize__decor-star-beige lazy">
    <p class="about-prize__descr"><?php echo $section['descr'] ?></p>
    <picture class="about-prize__pic lazy">
      <source type="image/webp" srcset="#" data-srcset="<?php echo str_replace( ['.jpg', '.png'], '.webp', $section['img']['url'] ) ?>">
      <img src="#" alt="#" data-src="<?php echo $section['img']['url'] ?>" class="about-prize__img">
    </picture>
  </div>
  <h2 class="about-prize__second-title"><?php echo $section['stages_title'] ?></h2>
  <ul class="about-prize__stages stages"> <?php
    foreach ( $section['stages'] as $stage ) : ?>
      <li class="stage">
        <p class="stage__text"><?php echo $stage['text'] ?></p>
      </li>
      <span class="stage__line"></span> <?php
    endforeach ?>
  </ul>
</section>