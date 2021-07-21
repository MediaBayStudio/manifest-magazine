<aside class="menu" style="display:none">
  <div class="menu__cnt">
    <div class="menu__hdr">
      <button type="button" class="menu__close"></button>
      <a href="<?php echo $site_url ?>" class="menu__logo">
        <img src="<?php echo $logo_url ?>" alt="Логотип Manifest Magazine" class="menu__logo-img">
      </a>
    </div> <?php
    wp_nav_menu( [
      'theme_location'  => 'header_menu',
      'container'       => 'nav',
      'container_class' => 'menu__nav',
      'menu_class'      => 'menu__nav-list',
      'items_wrap'      => '<ul class="%2$s">%3$s</ul>'
    ] ) ?>
    <div class="menu__right"> <?php
      $callback_page = get_page_by_title( 'Стать автором / Предложить идею' );
      $callback_page_url = get_the_permalink( $callback_page->ID );
      $menu_menu_links = get_field( 'links', wp_get_nav_menu_object( 16 ) ) ?>
      <a href="<?php echo $callback_page_url ?>" class="menu__callback-link btn">Стать автором</a>
      <nav class="menu__nav">
        <ul class="menu__nav-list"> <?php
          foreach ( $menu_menu_links as $link ) : ?>
            <li class="menu__nav-li"><a href="<?php echo $link['link']['url'] ?>" class="nav-link"><?php echo $link['link']['title'] ?></a></li> <?php
          endforeach ?>
        </ul>
      </nav>
      <div class="menu__links"> <?php
        $links = [ 
          'instagram' => $instagram_link,
          'facebook' => $facebook_link,
          'twitter' => $twitter_link
        ];
        foreach ( $links as $key => $value ) :
          if ( $value ) : ?>
            <a href="<?php echo $value ?>" class="menu__link <?php echo $key ?>"></a> <?php
          endif;
        endforeach ?>
      </div>
    </div>
  </div>
</aside>