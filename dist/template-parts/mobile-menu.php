<aside class="menu" style="display:none">
  <div class="menu__cnt container lazy" data-src="#">
    <div class="menu__hdr">
      <a href="<?php echo $site_url ?>" class="menu__logo">
        <img src="<?php echo $logo_url ?>" alt="Логотип Manifest Magazine" class="menu__logo-img">
      </a>
      <button type="button" class="menu__close">
        <svg width="21" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 20" class="menu__close-svg"><path stroke="currentColor" d="M20.4455.353553L1.35359 19.4454M19.7384 19.4455L.646481.353591" class="menu__close-path"/></svg>
      </button>
    </div> <?php
    wp_nav_menu( [
      'theme_location'  => 'mobile_menu',
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
        foreach ( $social_links as $social_link_name => $social_link_url ) :
          if ( $social_link_url ) : ?>
            <a href="<?php echo $social_link_url ?>" target="_blank" class="menu__link <?php echo $social_link_name ?>"></a> <?php
          endif;
        endforeach ?>
      </div>
    </div>
  </div>
</aside>