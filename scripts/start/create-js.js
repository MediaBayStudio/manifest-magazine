let path = require('path').posix,
  fs = require('fs'),
  argv = require('yargs').argv,
  mkdirpsync = require('mkdirpsync'),
  config = require('../config.js'),
  createFile = require('./create-file.js'),
  flexibleWordpress = config.flexibleWordpress,
  pages = config.pages,

  createJs = function() {

    // Создание файла для админки
    createFile(path.join(config.src.js, 'script-admin.js'));

    // Копирование jquery
    let jquerySrc = path.join('scripts', 'libs', 'js', 'jquery-3.5.1.min.js'),
      jqueryDest = path.join(config.src.js, 'jquery-3.5.1.min.js');

    try {
      fs.copyFileSync(jquerySrc, jqueryDest);
      console.log('Файл ' + jquerySrc+ ' скопирован');
    } catch (err) {
      console.log('Файл ' + jquerySrc + ' не найден');
    }

    if (flexibleWordpress) {
      // Создадем для каждой страницы отдельный js
      pages.forEach(function(page) {

        // Проверка на отдельную WP страницу
        if (page.slice(0, 3) !== 'wp:') {
          page = page.replace(/,.*$/, '');

          let {
            // '/home/user/dir/file.txt'
            root, // '/'
            dir, // '/home/user/dir'
            base, // 'file.txt'
            ext, // '.txt'
            name, // file
          } = path.parse(path.normalize(page)),
            filepath = path.join(config.src.js, 'script-' + name + '.js');

          createFile(filepath)
        }

      });

      config.js.forEach(function(el) {
        el = el.replace(/\s?\[defer\]/, '');

        let src = path.join(config.libs.js, el),
          dest = config.src.js;
        try {
          mkdirpsync(dest);
          fs.copyFileSync(src, path.join(dest, el));
          console.log('Файл ' + path.join(dest, el) + ' скопирован');
        } catch (err) {
          console.log('Файл ' + src + ' не найден');
        }
      });

    } else {

    }

    // Перемещаем все js компоненты
    config.jsComponents.forEach(function(el) {
      let src = path.join(config.libs.js, 'components', el),
        dest = path.join(config.src.js, 'components');
      try {
        mkdirpsync(dest);
        fs.copyFileSync(src, path.join(dest, el));
        console.log('Файл ' + path.join(dest, el) + ' скопирован');
      } catch (err) {
        console.log('Файл ' + src + ' не найден');
      }
    });

    // Перемещаем полифиллы и создаем для них служебный файл js-polyfills.php
    // на который будет приходить один get-запрос для получения нужных полифиллов
    // например, js-polyfills.php/?polyfills=closest|intersection-observer|custom-events|svg4everybody|
    try {
      let polyfills = '<?php\n$polyfills = [';
      // let polyfills = '<?php\n';

      fs.readdirSync(config.libs.polyfills).forEach(function(filename) {
        if (filename[0] !== '.') {
          let filepath = path.join(config.libs.polyfills, filename),
            dest = path.join(config.src.polyfills, filename);

          polyfills += '\n\t\'' + filename + '\' => <<<\'EOT\'\n' + fs.readFileSync(filepath).toString() + '\nEOT,\n\t';


          fs.copyFile(filepath, dest, function(err) {
            if (err) {
              throw err;
              console.log('Не удалось скопировать файл: ' + filepath);
              console.log(err);
            } else {
              console.log('Файл ' + filename + ' скопирован');
            }
          });

        }
      });

      polyfills += '\n];';

      let ending = `
if ( $_GET ) {
  $needdful_polyfills = explode( '|', $_GET['polyfills'] );

  if ( $needdful_polyfills ) {
    $needdful_polyfills_len = count( $needdful_polyfills );
    if ( $needdful_polyfills_len > 0 ) {
      foreach ( $needdful_polyfills as $neddful_polyfill ) {
         if ( $polyfills[ $neddful_polyfill ] ) {
          $response .= $polyfills[ $neddful_polyfill ];
         }
       } 
    }
  }

  echo $response;
}
`;
      polyfills += ending;

      createFile(path.join(config.src.path, 'js-polyfills.php'), polyfills);

      // console.log(files);
    } catch (err) {
      console.log(err);
    }

  };

module.exports = createJs;