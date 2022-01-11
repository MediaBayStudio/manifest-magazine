<?php
$author = $GLOBALS['current_author'];
$author_id = $author->ID;
$author_name = $author->display_name;
$author_posts_count = count_user_posts( $author_id );
$author_faq = get_posts( [
  'post_type' => 'author_question',
  'meta_key' => 'expert',
  'meta_value' => $author_id
] );
$author_faq_count = count( $author_faq );
$author_descr = get_the_author_meta( 'description', $author_id );
$author_fields = get_fields( $author );
$author_category = $author_fields['author_category'];
$avatar_url = $author->avatar_url;
$avatar_webp_url = $author->avatar_webp_url;

$parent_categories = get_terms( [
  'taxonomy' => 'category',
  'parent' => 0,
  'hide_empty' => false // потом переделать на true
] );

$author_categories = '<button type="button" class="author-hero-articles-sect__category-btn active" data-category-id="0">Все темы</button><span class="author-hero-articles-sect__category-dot"></span>';

// $author_all_articles = '<div class="author-hero-articles-sect__block active" data-category-id="0">';
$all_articles = [];

$author_articles = [];

$i = 0;
foreach ( $parent_categories as $parent_category ) {
  $articles = get_posts( [
    'numberposts' => -1,
    'category' => $parent_category->term_id,
    'author' => $author_id
  ] );

  if ( $articles ) {
    $author_articles[ $i ] = '<div class="author-hero-articles-sect__block" data-category-id="' . $parent_category->term_id . '">';

    foreach ( $articles as $article ) {
      $article_thumbnail_id = get_post_thumbnail_id( $article->ID );
      $article_thumbnail_url = wp_get_attachment_image_url( $article_thumbnail_id, 'author_article' );
      if ( !$article_thumbnail_url ) {
        $article_thumbnail_url = wp_get_attachment_image_url( $article_thumbnail_id, 'thumb' );
      }
      $article_thumbnail_webp_url = str_replace( ['.jpg', '.png'], '.webp', $article_thumbnail_url );
      $article_link = get_the_permalink( $article->ID );

      $article_html =
      '<div class="author-hero-article">
        <a href="' . $article_link . '" class="author-hero-article__link-pic">
          <picture class="author-hero-article__pic lazy">
            <source type="image/webp" srcset="#" data-srcset="' . $article_thumbnail_webp_url . '">
            <img src="#" alt="#" data-src="' . $article_thumbnail_url . '" class="author-hero-article__img">
          </picture>
        </a>
        <div class="author-hero-article__text">
          <a href="' . $article_link . '" class="author-hero-article__link-title">
            <span class="author-hero-article__title">' . $article->post_title . '</span>
          </a>
          <p class="author-hero-article__descr">' . get_excerpt( [
            'text' => $article->post_content,
            'maxchar' => 120,
            'autop' => false,
            'ignore_more' => true
            ] ) . '</p>
        </div>
      </div>';

      $author_articles[ $i ] .= $article_html;
      $all_articles[ $article->ID ] = $article_html;

      // $author_all_articles .= $article_html;
      // $author_all_articles .= $article_html;
    } // endforeach ( $articles as $article )

    $author_categories .= '<button type="button" class="author-hero-articles-sect__category-btn" data-category-id="' . $parent_category->term_id . '">' . $parent_category->name . '</button><span class="author-hero-articles-sect__category-dot"></span>';

    $author_articles[ $i ] .= '</div>';

    $i++;
  } // endif ( $articles )
  unset( $articles );
} // endforeach ( $parent_categories as $parent_category )

// $author_all_articles .= '</div>' ?>

<section class="author-hero container">
  <picture class="author-hero__pic">
    <source type="image/webp" srcset="<?php echo $avatar_webp_url ?>">
      <img src="<?php echo $avatar_url ?>" alt="<?php echo $author_name ?>" class="author-hero__img">
  </picture>
  <h1 class="author-hero__title"><?php echo $author_name ?></h1>
  <a href="<?php echo get_term_link( $author_category ) ?>" class="author-hero__category"><?php echo $author_category->name ?></a>
  <p class="author-hero__descr"><?php echo $author_descr ?></p> <?php 
  if ( $author_posts_count || $author_faq_count ) : ?>
    <div class="author-hero__count"> <?php
      if ( $author_posts_count ) : ?>
        <span class="author-hero__count-posts">Публикаций &mdash; <?php echo $author_posts_count ?></span> <?php
      endif;
      if ( $author_posts_count && $author_faq_count ) : ?>
        / <?php
      endif;
      if ( $author_faq_count ) : ?>
        <span class="author-hero__count-faq">Ответы &mdash; <?php echo $author_faq_count ?></span> <?php
      endif ?>
    </div> <?php
  endif ?>

</section> <?php

if ( $author_articles ) : ?>
  <section class="author-hero-articles-sect sect container" id="author-hero-articles-sect">
    <div class="author-hero-articles-sect__categories">
      <hr class="author-hero-articles-sect__categories-line"> <?php
      echo $author_categories ?>
    </div>
    <div class="author-hero-articles-sect__articles author-hero-articles">
      <div class="author-hero-articles-sect__block active" data-category-id="0"> <?php
        foreach ( $all_articles as $author_article ) {
          echo $author_article;
        }  ?>
      </div> <?php
      // echo $author_all_articles;
      foreach ( $author_articles as $author_article ) {
        echo $author_article;
      } ?>
    </div>
  </section> <?php
endif;
if ( $author_faq ) : ?>
  <section class="author-hero-faq-sect sect container">
    <h2 class="author-hero-faq-sect__title sect-title sect-title-underline">Ответы эксперта</h2>
    <div class="author-hero-faq-sect__faq faq-block"> <?php
      foreach ( $author_faq as $faq ) {
        create_faq_card( [
          'object' => $faq,
          'lazyload' => true
        ] );
      } ?>
    </div>
  </section> <?php
endif ?>
