<?php 
$form_class = is_search() ? ' search-hero__form' : ''; ?>
<form role="search" method="get" action="<?php echo home_url( '/' ) ?>" class="search-form<?php echo $form_class ?>">
  <input type="search" value="<?php echo get_search_query() ?>" name="s" placeholder="Введите запрос" class="search__inp">
</form> 