<section class="about-team sect container"<?php echo $section_id ?>>
  <h2 class="about-team__title sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
  <div class="about-team__team team">
    <div class="team__nav"></div> <?php
    foreach ( $section['team'] as $team ) : ?>
      <div class="team-card">
        <picture class="team-card__pic lazy">
          <source type="image/webp" srcset="#" data-srcset="<?php echo str_replace( ['.jpg', '.png'], '.webp', $team['img']['url'] ) ?>">
          <img src="#" alt="#" data-src="<?php echo $team['img']['url'] ?>" class="team-card__img">
        </picture>
        <span class="team-card__title"><?php echo $team['title'] ?></span>
        <span class="team-card__role"><?php echo $team['role'] ?></span>
        <p class="team-card__descr"><?php echo $team['descr'] ?></p>
      </div> <?php
    endforeach ?>
  </div>
</section>