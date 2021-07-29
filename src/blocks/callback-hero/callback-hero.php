<section class="callback-hero">
  <h1 class="callback-hero__title sect-h1 container"><?php echo $section['hero_title'] ?></h1>
  <div class="callback-hero__body container">
    <div class="callback-hero__text-content">
      <h2 class="callback-hero__subtitle sect-title sect-title-underline"><?php echo $section['title'] ?></h2>
      <p class="callback-hero__text"><?php echo $section['descr'] ?></p>
    </div>
    <div class="callback-hero__forms">
      <div class="callback-hero__forms-header">
        <button type="button" class="callback-hero__forms-btn active" data-form="1">Стать автором</button>
        <button type="button" class="callback-hero__forms-btn" data-form="2">Предложить идею</button>
        <hr class="callback-hero__forms-line">
      </div>
      <div class="callback-hero__wrap-form active lazy" data-src="#" data-form="1"> <?php
        echo do_shortcode( '[contact-form-7 id="' . $section['became_an_author_form'] . '" html_class="callback-hero__form" html_id="became-an-author-form"]' ) ?>
      </div>
      <div class="callback-hero__wrap-form hide lazy" data-src="#" data-form="2"> <?php
        echo do_shortcode( '[contact-form-7 id="' . $section['offer_an_idea_form'] . '" html_class="callback-hero__form" html_id="offer-an-idea-form"]' ) ?>
      </div>
    </div>
  </div>
</section>