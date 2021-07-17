let /*path = require('path'),*/
path = require('path').posix,

  localServerDest = path.normalize('/Applications/MAMP/htdocs/manifest-magazine/'),
  // localServerDest = path.normalize('C:/OSPanel/domains/zubteh/'),
  // localServerDest = path.normalize('test'),

  themeDest = path.normalize('/Applications/MAMP/htdocs/manifest-magazine/wp-content/themes/manifest-magazine/'),
  // themeDest = path.normalize('C:/OSPanel/domains/zubteh/wp-content/themes/zubteh/'),
  // themeDest = path.normalize('test'),
  themeAssetsDest = path.join(themeDest, 'src'),

  destPath = themeDest,
  destAssets = path.join(themeDest, 'src'),
  srcPath = path.normalize('src'),
  phpIncludesPath = path.normalize('./scripts/libs/inc/'),
  wordpress = true,
  flexibleWordpress = true, // Все страницы формируются только из вордпресса, без require '...blockName...'

  // destPath = path.relative('gulpfile.js', 'C:/OSPanel/domains/gazobetonstroi/wp-content/themes/gazobetonstroi/'),

  // Из папки с блоком scss идут в css, js в js, php/html в parts

  config = {
    localServerDest: localServerDest,
    wordpress: wordpress,
    flexibleWordpress: flexibleWordpress,
    themeStyleTemplate: [
      '@charset "UTF-8";',
      '/*',
      'Theme Name: Manifest Magazine',
      'Author: Медиа Гавань',
      'Author URI: https://media-bay.ru/',
      'Version: 1.0',
      '*/'
    ],

    dbname: 'andrejqb_manifes',
    dbhost: '127.0.0.1:8889',
    dbuser: 'admin',
    dbpass: '12345',
    siteName: 'name',
    siteurl: 'http://localhost:8888/manifest-magazine',
    wpAdmin: 'admin',
    siteTtitle: 'Manifest Magazine',
    siteDescr: 'descr',
    adminEmail: 'alexander@media-bay.ru',

    // Путь для локальных плагинов
    wpPluginsPath: path.normalize('/Users/administrator/Desktop/wordpress-plugins/'),

    // Плагины с .zip на конце будут взяты из локального хранилища
    // остальные будут скачаны из репозитория вордпресс
    wpPlugins: [
      'cyr2lat',
      'contact-form-7.zip',
      'flamingo',
      'contact-form-7-honeypot',
      // 'advanced-custom-fields-table-field',
      'advanced-custom-fields-pro.zip',
      'backupbuddy-8.7.3.0.zip'
    ],

    dest: {
      path: destPath,
      // Путь к файлам разработчика в dest
      sourceCode: destAssets,
      // Остальные пути
      parts: path.join(destPath, (wordpress ? 'template-parts' : 'layouts')),
      blocks: path.join(destPath, 'blocks'),
      scss: path.join(destPath, 'css'),
      fonts: path.join(destPath, 'fonts'),

      js: path.join(destPath, 'js'),
      json: destPath,
      polyfills: path.join(destPath, 'js/polyfills'),

      php: destPath,
      inc: path.join(destPath, 'inc'),
      html: destPath,

      img: path.join(destPath, 'img')
    },

    src: {
      path: srcPath,
      assets: path.join(srcPath, 'scss/assets'),
      blocks: path.join(srcPath, 'blocks'),
      scss: path.join(srcPath, 'scss'),
      fonts: path.join(srcPath, 'fonts'),

      js: path.join(srcPath, 'js'),
      json: srcPath,
      polyfills: path.join(srcPath, 'js/polyfills'),

      php: srcPath,
      inc: path.join(srcPath, 'inc'),
      html: srcPath,

      img: path.join(srcPath, 'img')
    },

    libs: {
      pages: path.normalize('./scripts/libs/'),
      animations: path.normalize('./scripts/libs/animations/'),
      fonts: path.normalize('./scripts/libs/fonts/'),
      css: path.normalize('./scripts/libs/css/'),
      js: path.normalize('./scripts/libs/js/'),
      polyfills: path.normalize('./scripts/libs/polyfills/'),
      phpIncludes: path.normalize('./scripts/libs/inc/')
    },

    // Медиа-запросы для сайта
    cssBreakpoints: [
      '',
      '(min-width:575.98px)',
      '(min-width:767.98px)',
      '(min-width:1023.98px)',
      '(min-width:1279.98px)'
    ],

    // Ширина контейнеров
    containerWidth: [
      280,
      536,
      720,
      960,
      1200
    ],

    cssAnimations: {
      'translateToBottom': true,
      'spin': true,
      'searching': false
    },

    cssColors: {
      'blue': '#B5CFD3',
      'darkBkue': '#4A7987',
      'dirtyBlue': '#B1BFBE',
      'beige': '#BAABA1',
      'lightBeige': '#F0E8DF',
      'brown': '#AC7F55',
      'brightOrange': '#E73E1B',
      'lightGray': '#E4E4E4',
      'gray1': '#C4C4C4',
      'gray2': '#A3A3A3',
      'gray3': '#7E7E7E',
      'gray4': '#5F5F5F',
      'darkGray': '#5F5F5F',
      'light': '#F3F3F3',
      'lightBlue': '#F0FBFE',
      'lightYellow': '#FEFBF6',
      'orange': '#E46A4F',
      'white': '#fff',
      'black': '#282828'
    },

    fonts: [
      'QuincyCF-Bold',
      'Raleway-Regular',
      'SegoeUI-SemiBold'
    ],

    variables: {
      // containerWidth будет создан автоматичеки

      // Вертикальные отступы для всех размеров экранов будут созданы автоматически
      // 0 - значит пропустить
      'sectionVerticalPadding': [
        30,
        0,
        40,
        45,
        50
      ]

      // sectionHorizontalPadding будут созданы автоматичеси

      // mediaQuery будут созданы автоматически

    },

    // Формирование файла assets.css,
    // он будет вставлен в основной файл стилей темы
    generalAssets: [
      path.normalize('src/scss/assets/animations'),
      path.normalize('src/scss/assets/fonts'),
      path.normalize('src/scss/assets/grid'),
      path.normalize('src/scss/assets/reset')
    ],

    // Будут вставлены в каждый файл .scss
    otherAssets: [
      path.normalize('src/scss/assets/colors'),
      path.normalize('src/scss/assets/mixins'),
      path.normalize('src/scss/assets/variables')
    ],

    // У полифиллов просто сканируется вся папка
    // polyfills: {
    //   'intersection-observer.min.js': true,
    //   'custom-events.min.js': true,
    //   'closest.min.js': true
    // },

    phpIncludes: {
      // 'ajaxSearch': {
      //   'comment': 'Замена стандартного поиска на ajax +расшиерние поиска по acf полям',
      //   'path': 'ajax-search.php'
      // },
      'buildStyles': {
        'comment': 'Функция формирования стилей для страницы при сохранении страницы',
        'path': 'build-styles.php',
        'onlyAdmin': true
      },
      'buildScripts': {
        'comment': 'Функция формирования скриптов для страницы при сохранении страницы',
        'path': 'build-scripts.php',
        'onlyAdmin': true
      },
      'createImages': {
        'comment': 'Функция создания webp для изображений',
        'path': 'create-images.php',
        'onlyAdmin': true
      },
      'createPicture': {
        'comment': 'Создание <picture> для img',
        'path': 'create-picture.php'
      },
      'createLinkPreload': {
        'comment': 'Создание <link rel="preload" /> для img',
        'path': 'create-link-preload.php'
      },
      'buildPagesInfo': {
        'comment': 'Формирование файла pages-info.json, для понимания на какой странице какие секции используются',
        'path': 'build-pages-info.php',
        'onlyAdmin': true
      },
      'enableSvgAndWebp': {
        'comment': 'Активация SVG и WebP в админке',
        'path': 'enable-svg-and-webp.php'
      },
      'enqueueStylesAndScripts': {
        'comment': 'Регистрация стилей и скриптов для страниц и прочие манипуляции с ними',
        'path': 'enqueue-styles-and-scripts.php'
      },
      'disableWpScriptsAndStyles': {
        'comment': 'Отключение стандартных скриптов и стилей, гутенберга, emoji и т.п.',
        'path': 'disable-wp-scripts-and-styles.php'
      },
      'menus': {
        'comment': 'Регистрация меню на сайте',
        'path': 'menus.php'
      },
      'optionsFileds': {
        'comment': 'Регистрация доп. полей в меню Настройки->Общее',
        'path': 'options-fields.php'
      },
      'registerCustomPostsTypesAndTaxonomies': {
        'comment': 'Регистрация и изменение записей и таксономий',
        'path': 'register-custom-posts-types-and-taxonomies.php'
      },
      'adminMenuActions': {
        'comment': 'Удаление лишних пунктов из меню админ-панели и прочие настройки админ-панели',
        'path': 'admin-menu-actions.php',
        'onlyAdmin': true
      },
      'themeSupportAndThumbnails': {
        'comment': 'Нужные поддержки темой, рамзеры для нарезки изображений',
        'path': 'theme-support-and-thumbnails.php'
      },
      'phpPathJoin': {
        'comment': 'Склеивание путей с правильным сепаратором',
        'path': 'php-path-join.php'
      }
      // 'printBreadcrumbs': {
      //   'comment': 'Функция формирования хлебных крошек',
      //   'path': 'print-breadcrumbs.php'
      // }
      // 'name': {
      //   'comment': '',
      //   'path': phpIncludesPath + 'ajax'
      // }
    },

    // phpIncludes: {

    //   [phpIncludesPath + 'ajax-search.php']: false,
    //   [phpIncludesPath + 'build-styles.php']: true,
    //   [phpIncludesPath + 'build-scripts.php']: true,
    //   [phpIncludesPath + 'build-pages-info.php']: true,
    //   [phpIncludesPath + 'disable-wp-scripts-and-styles.php']: true,
    //   [phpIncludesPath + 'enqueue-styles-and-scripts.php']: true,
    //   [phpIncludesPath + 'menus.php']: true,
    //   [phpIncludesPath + 'options-fields.php']: true,
    //   [phpIncludesPath + 'register-custom-posts-types-and-taxonomies.php']: true,
    //   [phpIncludesPath + 'remove-admin-menu.php']: true,
    //   [phpIncludesPath + 'theme-support-and-thumbnails.php']: true
    // }

  };

config.pages = [
  // Страницы потом без проблем можно переименовать.

  // Шаблон: path, page.php, title, page-slug
  // в таком случае будут созданы файлы для страницы и будет создана страница в wordpress,
  // которой также будет назначен соответствующий шаблон.

  path.join(srcPath, 'index.php'),
  path.join(srcPath, 'about.php'),
  path.join(srcPath, 'contacts.php'),
  path.join(srcPath, 'callback.php'),
  path.join(srcPath, 'author.php'),
  path.join(srcPath, 'authors.php'),
  path.join(srcPath, 'category.php'),
  path.join(srcPath, 'single.php'),
  path.join(srcPath, 'search.php'),
  path.join(srcPath, '404.php')
];

// При flexibleWordpress будет всталвено в style.css файл темы
// при !flexibleWordpress будет вставлено как указано в scssImports
config.generalScss = [
  path.join(config.src.scss, 'style/buttons.scss'),
  path.join(config.src.scss, 'style/interface.scss'),
  path.join(config.src.scss, 'style/popups.scss'),
  path.join(config.src.scss, 'style/forms.scss'),
  path.join(config.src.scss, 'style/sliders.scss')
];

// Для каждого блока создаются scss файлы по размрам экранов и js файл
config.blocks = [
  // Главная страница
  path.join(config.src.blocks, 'header/header.php'),
  path.join(config.src.blocks, 'mobile-menu/mobile-menu.php'),
  path.join(config.src.blocks, 'index-hero/index-hero.php'),
  path.join(config.src.blocks, 'index-articles/index-articles.php'),
  // path.join(config.src.blocks, 'category-articles/category-articles.php'),
  // path.join(config.src.blocks, 'authors/authors.php'),
  path.join(config.src.blocks, 'index-quote/index-quote.php'),
  // path.join(config.src.blocks, 'faq/faq.php'),
  path.join(config.src.blocks, 'index-subscribe/index-subscribe.php'),

  path.join(config.src.blocks, 'category-hero/category-hero.php'),
  path.join(config.src.blocks, 'category-articles/category-articles.php'),

  path.join(config.src.blocks, 'authors-hero/authors-hero.php'),
  path.join(config.src.blocks, 'faq/faq.php'),

  path.join(config.src.blocks, 'author-hero/author-hero.php'),
  path.join(config.src.blocks, 'author-articles/author-articles.php'),
  // path.join(config.src.blocks, 'faq/faq.php'),

  path.join(config.src.blocks, 'about-hero/about-hero.php'),
  path.join(config.src.blocks, 'about-concept/about-concept.php'),
  path.join(config.src.blocks, 'about-team/about-team.php'),
  path.join(config.src.blocks, 'about-prize/about-prize.php'),

  path.join(config.src.blocks, 'callback-hero/callback-hero.php'),

  path.join(config.src.blocks, 'contacts-hero/contacts-hero.php'),
  path.join(config.src.blocks, 'contacts-contact-us/contacts-contact-us.php'),

  path.join(config.src.blocks, 'article/article.php'),

  path.join(config.src.blocks, 'hero-404/hero-404.php'),
  path.join(config.src.blocks, 'footer/footer.php'),

  // Попапы
  path.join(config.src.blocks, '/thanks-popup/thanks-popup.php')

];

// По умолчанию в style.css вставляется generalAssets и generalScss
// config.themeStyleImports = [
//   config.src.assets + 'animations',
//   config.src.assets + 'fonts',
//   config.src.assets + 'grid',
//   config.src.assets + 'reset',
//   config.src.scss + 'buttons/buttons',
//   config.src.scss + 'interface/interface',
//   config.src.scss + 'popups/popups',
//   config.src.scss + 'forms/forms',
//   config.src.scss + 'sliders/sliders'
// ];

// Главный файл стилей (работает только с !flexibleWordpress)
config.mainScss = [
  path.join(config.src.scss, 'style.css')
];

// if flexibleWordpress, то будут созданы css файлы
// для каждой страницы, при этом страницы в скобках исключаются
// для страниц в скобках будет создан один файл

// if !flexibleWordpress, то будут созданы все файлы по списку
config.scss = [
  // ! - запрещает создавать размеры для файлов
  // 'src/scss/style-service (design, context, instagram, perfomance, seo, web)',
  path.normalize('src/scss/!hover'),
  // Стили для админки
  path.normalize('src/scss/style-admin')
];

// Здесь нужно задать импорты в scss файлы
// будет работать только если flexibleWordpress: false
// config.scssImports = {
//   'src/scss/style-index': [
//     'src/scss/general/interface/interface'
//   ]
// };

// Если flexibleWordpress, то для каждой страницы будет создан ее собственный js
// Если !flexibleWordpress, то указываются js файлы и defer
// Также будет создан и подключен script-admin.js, для админ-панели
config.js = [
  'svg4everybody.min.js',
  'slick.min.js',
  'lazy.min.js', ,
  'Popup.min.js',
  'script.js'
];

config.jsComponents = [
  // 'main.js',
  'utils.js',
  'menu.js',
  'popups.js',
  'validateForms.js',
  'telMask.js',
  'sliders.js'
];

module.exports = config;