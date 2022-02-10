<?php

// Что за функция и зачем она не понятно, забыл
function my_get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category', $post = null, $parent_term = null ) {
  global $wpdb;

  if ( ! $post ) {
    $post = get_post();
  } else if ( ! is_object( $post ) ) {
    $post = get_post( $post );
  }


  if ( ! $post || ! taxonomy_exists( $taxonomy ) ) {
    return null;
  }

  $current_post_date = $post->post_date;

  $join     = '';
  $where    = '';
  $adjacent = $previous ? 'previous' : 'next';

  if ( ! empty( $excluded_terms ) && ! is_array( $excluded_terms ) ) {
    if ( false !== strpos( $excluded_terms, ' and ' ) ) {
      _deprecated_argument(
        __FUNCTION__,
        '3.3.0',
        sprintf(
          /* translators: %s: The word 'and'. */
          __( 'Use commas instead of %s to separate excluded terms.' ),
          "'and'"
        )
      );
      $excluded_terms = explode( ' and ', $excluded_terms );
    } else {
      $excluded_terms = explode( ',', $excluded_terms );
    }

    $excluded_terms = array_map( 'intval', $excluded_terms );
  }

  $excluded_terms = apply_filters( "get_{$adjacent}_post_excluded_terms", $excluded_terms );

  if ( $in_same_term || ! empty( $excluded_terms ) ) {
    if ( $in_same_term ) {
      $join  .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
      $where .= $wpdb->prepare( 'AND tt.taxonomy = %s', $taxonomy );

      if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
        return '';
      }
      $term_array = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );

      // Remove any exclusions from the term array to include.
      $term_array = array_diff( $term_array, (array) $excluded_terms );
      $term_array = array_map( 'intval', $term_array );

      if ( ! $term_array || is_wp_error( $term_array ) ) {
        return '';
      }
      // var_dump( $parent_term );
      // $where .= ' AND tt.term_id IN (' . implode( ',', $term_array ) . ')';
      $where .= ' AND tt.term_id IN (' . $parent_term . ')';

      // var_dump( $where );
    }

    if ( ! empty( $excluded_terms ) ) {
      $where .= " AND p.ID NOT IN ( SELECT tr.object_id FROM $wpdb->term_relationships tr LEFT JOIN $wpdb->term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) WHERE tt.term_id IN (" . implode( ',', array_map( 'intval', $excluded_terms ) ) . ') )';
    }
  }

  if ( is_user_logged_in() ) {
    $user_id = get_current_user_id();

    $post_type_object = get_post_type_object( $post->post_type );
    if ( empty( $post_type_object ) ) {
      $post_type_cap    = $post->post_type;
      $read_private_cap = 'read_private_' . $post_type_cap . 's';
    } else {
      $read_private_cap = $post_type_object->cap->read_private_posts;
    }

    $private_states = get_post_stati( array( 'private' => true ) );
    $where         .= " AND ( p.post_status = 'publish'";
    foreach ( (array) $private_states as $state ) {
      if ( current_user_can( $read_private_cap ) ) {
        $where .= $wpdb->prepare( ' OR p.post_status = %s', $state );
      } else {
        $where .= $wpdb->prepare( ' OR (p.post_author = %d AND p.post_status = %s)', $user_id, $state );
      }
    }
    $where .= ' )';
  } else {
    $where .= " AND p.post_status = 'publish'";
  }

  $op    = $previous ? '<' : '>';
  $order = $previous ? 'DESC' : 'ASC';

  $join = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_term, $excluded_terms, $taxonomy, $post );

  $where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare( "WHERE p.post_date $op %s AND p.post_type = %s $where", $current_post_date, $post->post_type ), $in_same_term, $excluded_terms, $taxonomy, $post );

  $sort = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1", $post, $order );

  $query     = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort";
  $query_key = 'adjacent_post_' . md5( $query );
  $result    = wp_cache_get( $query_key, 'counts' );
  if ( false !== $result ) {
    if ( $result ) {
      $result = get_post( $result );
    }
    return $result;
  }

  $result = $wpdb->get_var( $query );
  if ( null === $result ) {
    $result = '';
  }

  wp_cache_set( $query_key, $result, 'counts' );

  if ( $result ) {
    $result = get_post( $result );
  }

  return $result;
}

function create_article( $args ) {
  global $article_thumbnail_data, $webp_support;

  if ( $_POST ) {
    $args = $_POST;
  }

  $defaults = [
    'related_articles' => false,
    'next_article' => false
  ];

  $parsed_args = wp_parse_args( $args, $defaults );

  $exists_post = $parsed_args['exists_post'];
  $exclude_posts = $parsed_args['exclude_posts'];
  // $parent_category = $parsed_args['parent_category'];

  if ( $parsed_args['article'] ) {
    $article = $parsed_args['article'];
    $exists_post = $article;
  }

  if ( $parsed_args['next_article'] ) {
    $article = get_posts( [
      'numberposts' => 1,
      // 'category' => $parsed_args['parent_category'],
      'exclude' => $parsed_args['exclude_posts']
    ] )[0];
  }

  if ( $parsed_args['related_articles'] ) {
    $related_articles_args = [
      'numberposts' => 3,
      'exclude' => $exclude_posts,
      'category' => $parent_category->term_id,
      'orderby' => 'rand'
    ];

    $related_articles = get_posts( $related_articles_args );

    $related_articles_html = '
      <section class="related-articles sect container">
        <h2 class="related-articles__title sect-title sect-title-underline">Статьи по теме</h2>
        <div class="related-articles__articles">';
          foreach ( $related_articles as $related_article ) {
            $related_articles_html .= create_article_card( [
              'object' => $related_article,
              'lazyload' => true,
              'print' => false
            ] );
          }
    $related_articles_html .= '
        </div>
      </section>';
  }

  if ( $related_articles && count( $related_articles ) > 2 && $parsed_args['next_article'] ) {
    echo $related_articles_html;
  }

  if ( $article ) :
    $terms = get_the_terms( $article->ID, 'category' );
    // var_dump( $terms );
    foreach ( $terms as $term ) {
      if ( $term->parent ) {
        $child_category = $term;
      } else {
        $parent_category = $term;
      }
    } ?>
    <article class="article sect container" data-post-id="<?php echo $article->ID ?>" data-parent-category="<?php echo $parent_category->term_id ?>">
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
          <h1 class="article__header-title"><?php echo $article->post_title ?></h1>
          <div class="article__author"> <?php
            $author_id = $article->post_author;
            $author_category = get_the_author_meta( 'author_category', $author_id );
            $author_category = get_term( $author_category );
            $author_url = get_author_posts_url( $author_id );
            $author_name = get_the_author_meta( 'display_name', $author_id );
            $avatar_id = get_the_author_meta( 'avatar', $author_id );
            $avatar_url = wp_get_attachment_url( $avatar_id );
            $avatar_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $avatar_url ) ?>
            <a href="<?php echo $author_url ?>" class="article__author-pic-link">
              <picture class="article__author-pic">
                <source type="image/webp" srcset="<?php echo $avatar_webp_url ?>">
                <img src="<?php echo $avatar_url ?>" alt="<?php echo esc_attr( $author_name ) ?>" class="article__author-img" />
              </picture>
            </a>
            <div class="article__author-info">
              <a href="<?php echo $author_url ?>" class="article__author-name-link"><span class="article__author-name"><?php echo $author_name ?></span></a> <?php
              if ( $author_category->name === 'Без рубрики' ) {
                $style = ' style="display:none"';
              } else {
                $style = '';
              } ?>
              <div class="article__author-categories"<?php echo $style ?>>
                <a href="<?php echo get_term_link( $author_category->term_id ) ?>" class="article__author-categories-link"><?php echo $author_category->name ?></a>
              </div>
            </div>
          </div>
        </div>
        <picture class="article__header-pic"> <?php

          if ( !$article_thumbnail_data ) {
            $thumbnail_url = get_the_post_thumbnail_url( $article->ID );
            $thumbnail_id = get_post_thumbnail_id( $article->ID );
            $mobile_img = image_get_intermediate_size( $thumbnail_id, 'mobile' );
            $tablet_img = image_get_intermediate_size( $thumbnail_id, 'tablet' );
            $laptop_img = image_get_intermediate_size( $thumbnail_id, 'laptop' );
            $desktop_img = image_get_intermediate_size( $thumbnail_id, 'desktop' );
            $source_html = '';

            $thumbnail_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $thumbnail_url );
            $mobile_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $mobile_img['url'] );
            $tablet_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $tablet_img['url'] );
            $laptop_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $laptop_img['url'] );
            $desktop_webp_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $desktop_img['url'] );

            $post_author_avatar_preload_url = get_field( 'avatar', 'user_' . $article->post_author )['url'];

            if ( $webp_support ) {
              $post_author_avatar_preload_url = str_replace( ['.jpg', '.jpeg', '.png'], '.webp', $post_author_avatar_preload_url );
            }

            $article_thumbnail_data = [
              'mobile_img_url' => $mobile_img['url'],
              'tablet_img_url' => $tablet_img['url'],
              'laptop_img_url' => $laptop_img['url'],
              'desktop_img_url' => $desktop_img['url'],
              'mobile_webp_url' => $mobile_webp_url,
              'tablet_webp_url' => $tablet_webp_url,
              'laptop_webp_url' => $laptop_webp_url,
              'desktop_webp_url' => $desktop_webp_url,
              'type' => $mobile_img['mime-type']
            ];

            if ( !$desktop_img ) {
              $article_thumbnail_data['desktop_img_url'] = $thumbnail_url;
              $article_thumbnail_data['desktop_webp_url'] = $thumbnail_webp_url;
            }
          }

          $source_html = '';

          $source_html .= '<source type="image/webp" srcset="' . $article_thumbnail_data['mobile_webp_url'] . ', ' . $article_thumbnail_data['laptop_webp_url'] . ' 2x" media="(max-width:767.98px)">';
          $source_html .= '<source type="' . $article_thumbnail_data['type'] . '" srcset="' . $article_thumbnail_data['mobile_img_url'] . ', ' . $article_thumbnail_data['laptop_img_url'] . ' 2x" media="(max-width:767.98px)">';

          $source_html .= '<source type="image/webp" srcset="' . $article_thumbnail_data['tablet_webp_url'] . ', ' . $article_thumbnail_data['desktop_webp_url'] . ' 2x" media="(min-width:767.98px) and (max-width:1023.98px)">';
          $source_html .= '<source type="' . $article_thumbnail_data['type'] . '" srcset="' . $article_thumbnail_data['tablet_img_url'] . ', ' . $article_thumbnail_data['desktop_img_url'] . ' 2x" media="(min-width:767.98px) and (max-width:1023.98px)">';

          $source_html .= '<source type="image/webp" srcset="' . $article_thumbnail_data['desktop_webp_url'] . '" media="(min-width:1023.98px)">';
          $source_html .= '<source type="' . $article_thumbnail_data['type'] . '" srcset="' . $article_thumbnail_data['desktop_img_url'] . '" media="(min-width:1023.98px)">';

          echo $source_html ?>
          <img src="<?php echo $article_thumbnail_data['desktop_img_url'] ?>" alt="<?php echo esc_attr( $article->post_title ) ?>" class="article__header-img" />
        </picture>
      </header>
      <section class="article__body"> <?php
        echo apply_filters( 'the_content', get_the_content( null, null, $article->ID ) );
        #echo get_the_content( null, null, $article->ID ) ?>
      </section> <?php
      $tags = get_the_tags( $article->ID );
      if ( $tags ) : ?>
        <div class="article__tags"> <?php
          foreach ( $tags as $tag ) : ?>
            <span class="article__tag"><?php echo $tag->name ?></span> <?php
          endforeach ?>          
        </div> <?php
      endif ?>
      <div class="article__share"> <?php
        $permalink = get_the_permalink( $article->ID );
        if ( $_POST ) {
          $lazy_data = '"';
        } else {
          $lazy_data = ' lazy" data-src="#"';
        } ?>
        <span class="article__share-title">Поделиться</span>
        <a href="https://vkontakte.ru/share.php?url=<?php echo $permalink ?>" class="article__share-link vk-share-link<?php echo $lazy_data ?> target="_blank"></a>
        <!-- <a href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php #echo $permalink ?>" class="article__share-link facebook-share-link" target="_blank"></a> -->
        <!-- <a href="http://twitter.com/share?text=<?php #echo $article->post_title ?>&url=<?php #echo $permalink ?>" class="article__share-link twitter-share-link" target="_blank"></a> -->
        <a href="<?php echo urlencode( "https://t.me/share/url?url={$permalink}&text={$article->post_title}" ) ?>" class="article__share-link tg-share-link<?php echo $lazy_data ?> target="_blank"></a>
        <input type="text" value="<?php echo $permalink ?>" onclick="copyInputValue()" class="article__share-link share-link<?php echo $lazy_data ?>>
      </div>
    </article> <?php
    wp_reset_postdata();
  endif;

  if ( $related_articles && count( $related_articles ) > 2 && $parsed_args['article'] ) {
    echo $related_articles_html;
  }
  if ( $_POST ) {
    // var_dump( $_POST );
    die();
  }
}

add_action( 'wp_ajax_nopriv_create_article', 'create_article' );
add_action( 'wp_ajax_create_article', 'create_article' );