<?php 

$terms = get_the_terms( $post->ID, 'category' );

foreach ( $terms as $term ) {
  if ( $term->parent ) {
    $child_category = $term;
  } else {
    $parent_category = $term;
  }
}

 ?>

<article class="article sect container">
  <header class="article__header">
    <div class="article__header-inner"> <?php
      if ( $parent_category || $child_category ) : ?>
        <div class="article__categories"> <?php
        if ( $parent_category ) : ?>
          <a href="<?php echo get_term_link( $parent_category ) ?>" class="article__categories-link"><?php echo $parent_category->name ?></a> <?php
        endif;
        if ( $parent_category && $child_category ) {
          echo ' / ';
        }
        if ( $child_category ) : ?>
          <a href="<?php echo get_term_link( $child_category ) ?>" class="article__categories-link"><?php echo $child_category->name ?></a> <?php
        endif ?>
        </div> <?php
      endif ?>
      <h1 class="article__header-title"><?php the_title() ?></h1>
    </div>
    <picture class="article__header-pic"> <?php
      $thumbnail_url = get_the_post_thumbnail_url();
      $thumbnail_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $thumbnail_url ) ?>
      <source type="image/webp" srcset="<?php echo $thumbnail_webp_url ?>">
      <img src="<?php echo $thumbnail_url ?>" alt="#" class="article__header-img" />
    </picture>
    <div class="article__author"> <?php
      $author_id = $post->post_author;
      $author_category = get_the_author_meta( 'author_category', $author_id );
      $author_category = get_term( $author_category );
      $author_url = get_author_posts_url( $author_id );
      $author_name = get_the_author_meta( 'display_name', $author_id );
      $avatar_id = get_the_author_meta( 'avatar', $author_id );
      $avatar_url = wp_get_attachment_url( $avatar_id );
      $avatar_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $avatar_url ) ?>
      <picture class="article__author-pic">
        <source type="image/webp" srcset="<?php echo $avatar_webp_url ?>">
        <img src="<?php echo $avatar_url ?>" alt="<?php echo $author_name ?>" class="article__author-img" />
      </picture>
      <div class="article__author-info">
        <span class="article__author-name"><?php echo $author_name ?></span>
        <div class="article__author-categories">
          <a href="<?php echo get_term_link( $author_category->term_id ) ?>" class="article__author-categories-link"><?php echo $author_category->name ?></a>
        </div>
      </div>
    </div>
  </header>
  <section class="article__body"> <?php
    the_content() ?>
  </section>
</article>