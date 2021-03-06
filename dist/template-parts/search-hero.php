<section class="search-hero container"<?php echo $section_id ?>> <?php
    get_search_form() ?>
    <div class="search-hero__articles"> <?php
    // if ( $_GET['s'] === 'category' ) {
    //   global $wp_query;

    //   $args = [
    //     'numberposts' => -1,
    //     'category' => $_GET['term_id']
    //   ];

    //   // $posts = get_posts( [
    //   //   'numberposts' => -1,
    //   //   'category' => $_GET['term_id']
    //   // ] );

    //   $wp_query->get_posts( $args );

    // }
    // var_dump( $wp_query );
      if ( have_posts() ) {
        while ( have_posts() ) {
          the_post();
          $article_html = '';
          $article = $post;
          $article_thumbnail_id = get_post_thumbnail_id( $article->ID );
          $article_thumbnail_url = wp_get_attachment_image_url( $article_thumbnail_id, 'thumb' );
          $article_thumbnail_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $article_thumbnail_url );
          $article_link = get_the_permalink( $article->ID );
          $article_categories = get_the_terms( $article->ID , 'category' );
          foreach ( $article_categories as $category ) {
            if ( $category->parent ) {
              $article_child_category = $category;
            } else {
              $article_parent_category = $category;
            }
          }

          $article_html .=
          '<div class="search-hero-article">
            <a href="' . $article_link . '" class="search-hero-article__link-pic">
              <picture class="search-hero-article__pic lazy">
                <source type="image/webp" srcset="#" data-srcset="' . $article_thumbnail_webp_url . '">
                <img src="#" alt="#" data-src="' . $article_thumbnail_url . '" class="search-hero-article__img">
              </picture>
            </a>
            <div class="search-hero-article__text">
            <div class="search-hero-article__categories">';
            if ( $article_parent_category ) {
              $article_html .=
              '<a href="' . get_term_link( $article_parent_category ) . '" class="search-hero-article__parent-category">' . $article_parent_category->name . '</a>';
            }
            if ( $article_parent_category && $article_child_category ) {
              $article_html .= 
              ' / ';
            }

            if ( $article_child_category ) {
              $article_html .=
              '<a href="' . get_term_link( $article_child_category ) . '" class="search-hero-article__child-category">' . $article_child_category->name . '</a>';
            }
            $article_html .=
            '</div>
              <a href="' . $article_link . '" class="search-hero-article__link-title">
                <span class="search-hero-article__title">' . $article->post_title . '</span>
              </a>
              <p class="search-hero-article__descr">' . get_excerpt( [
                'maxchar'   =>  120,
                'autop' => false,
                'ignore_more' => true
              ] ) . '</p>
            </div>
          </div>';

          echo $article_html;
        }
      } else {
        echo '<p style="margin-top:30px">???? ???????????? ?????????????? ???????????? ???? ??????????????</p>';
      } ?>
    </div>
</section>