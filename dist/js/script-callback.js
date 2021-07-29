document.addEventListener('DOMContentLoaded', function() {

//=include ../blocks/header/header.js

//=include ../blocks/mobile-menu/mobile-menu.js

;(function() {

  tail.select('.field_select', {
    placeholder: 'Кто вы?'
  });

  let formsBlock = q('.callback-hero__forms'),
    formsHeaderBlock = q('.callback-hero__forms-header', formsBlock),
    line = q('.callback-hero__forms-line', formsBlock),
    activeButton = q('.callback-hero__forms-btn.active', formsHeaderBlock),
    setLinePosition = function(trf, w) {
      line.style.transform = 'translate3d(' + trf + 'px, 0, 0)';
      line.style.width = w / 2 + 'px';
    };
    // setBlockHeight = function() {
    //   let childs = formsBlock.children,
    //     height = 0;

    //   for (let i = 0, len = childs.length; i < len; i++) {
    //     let childHeight = childs[i].offsetHeight;

    //     if (childHeight) {
    //       height += childHeight;
    //       let childStyles = getComputedStyle(childs[i]);
    //       height += parseInt(childStyles.marginTop) + parseInt(childStyles.marginBottom);
    //     }

    //     console.log(childs[i].offsetHeight);
    //   }
    //   console.log(height);
    // };
    // blockPreviousHeight = 0;

  // setBlockHeight();

  setLinePosition(false, activeButton.offsetWidth);

  // formsBlock.style.height = formsBlock.scrollHeight + 'px';

  // formsBlock.addEventListener('transitionend', function(e) {
  //   let target = e.target,
  //     form = q('.callback-hero__wrap-form:not(.active)'),
  //     action = true;

  //   console.log(target);

  //   if (action && e.propertyName === 'opacity' && target.classList.contains('callback-hero__wrap-form')) {
  //     action = false;
  //     console.log('msg');
  //     form.classList.add('hide');
  //     formsBlock.style.height = 'auto';
  //     console.log(formsBlock.getAttribute('style'));
  //     formsBlock.offsetHeight;
  //     // console.log('clientHeight', formsBlock.clientHeight);
  //     // console.log('scrollHeight', formsBlock.scrollHeight);
  //     // console.log('offsetHeight', formsBlock.offsetHeight);
  //     // console.log('previousHeight', blockPreviousHeight);
  //     formsBlock.style.height = formsBlock.scrollHeight + 'px';
  //   }

  // });

  formsHeaderBlock.addEventListener('click', function(e) {

    let target = e.target;

    if (target.classList.contains('callback-hero__forms-btn')) {
      let targetForm = q('.callback-hero__wrap-form[data-form="' + target.getAttribute('data-form') + '"]' ,formsBlock),
        activeForm = q('.callback-hero__wrap-form.active', formsBlock),
        activeButton = q('.callback-hero__forms-btn.active', formsBlock);

      setLinePosition(target.offsetLeft, target.offsetWidth);

      // blockPreviousHeight = formsBlock.scrollHeight;

      // formsBlock.style.height = formsBlock.scrollHeight + 'px';

      // console.log('clientHeight', formsBlock.clientHeight);
      // console.log('scrollHeight', formsBlock.scrollHeight);
      // console.log('offsetHeight', formsBlock.offsetHeight);
      // console.log('previousHeight', blockPreviousHeight);

      // targetForm.classList.remove('hide');

      // formsBlock.scrollHeight;

      activeForm.classList.add('hide');
      targetForm.classList.add('active');
      target.classList.add('active');
      targetForm.classList.remove('hide');
      activeForm.classList.remove('active');
      activeButton.classList.remove('active');

    }

  });

})();

//=include ../blocks/footer/footer.js

});