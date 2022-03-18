//=include components/utils.js

window.addEventListener('load', function() {
  wp.blocks.registerBlockStyle( 'core/media-text', {
    name: 'without-grid-left',
    label: 'Без сетки слева'
  } );
  wp.blocks.registerBlockStyle( 'core/media-text', {
    name: 'without-grid-right',
    label: 'Без сетки справа'
  } );
  wp.blocks.registerBlockStyle( 'core/media-text', {
    name: 'without-grid',
    label: 'Без сетки'
  } );
});