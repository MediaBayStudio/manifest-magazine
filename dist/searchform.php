<?php 
$form_class = is_search() ? ' search-hero__form' : '';
$search_query = get_search_query() ?>
<form role="search" method="get" action="<?php echo home_url( '/' ) ?>" class="search-form<?php echo $form_class ?>"> <?php
  if ( $search_query === 'category' ) {
    $term = get_term( $_GET['term_id'] );
    $search_query = $term->name;
  } ?>
  <input type="search" value="<?php echo $search_query ?>" name="s" placeholder="Введите запрос" class="search__inp">
</form> 