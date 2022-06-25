(function() {
  const zodiacList = q('.horoscope-zodiac-list');
  const zodiactTextBlock = q('.horoscope-text');
  const zodiacName = q('.horoscope-text__zodiac', zodiactTextBlock);
  const zodiacDescr = q('.horoscope-text__descr', zodiactTextBlock);

  zodiacList.addEventListener('click', function(e) {
    const btn = e.target.closest('.zodiac-btn');

    if (btn) {
      const activeBtn = q('.zodiac-btn.active', zodiacList);
      if (activeBtn) {
        activeBtn.classList.remove('active');
      }

      btn.classList.add('active');
      zodiactTextBlock.classList.add('toggled');

      zodiacName.textContent = btn.dataset.zodiacName;
      zodiacDescr.innerHTML = btn.dataset.horoscopeText;

      setTimeout(() => zodiactTextBlock.classList.remove('toggled'), 500);
    }
  })
})();