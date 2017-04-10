
Wordpress Magic Boilerplate [![AUR](https://img.shields.io/aur/license/yaourt.svg)](https://www.gnu.org/licenses/gpl-3.0.en.html) [![WordPress](https://img.shields.io/badge/wordpress-4.7.3%20tested-brightgreen.svg)](https://ru.wordpress.org/releases/) [![built with gulp](https://img.shields.io/badge/build%20with-gulp-FA234B.svg)](http://gulpjs.com)
=======================

##WordPress Плагин##

**#RU**

<img width='100' height='100' src="public/images/wordpress.png" title='Wordpress Magic Boilerplate' alt='Wordpress Magic Boilerplate' align='right'>

Скелет плагина призванный привнести в ваш код WordPress код много срытой магии.
Позволяет повысить порог вхождения джуниоров в проект, ломает сложившие паттерны разработки WordPress.

##Полезность##

Исходя из требований современных тенденций веб разработки плагин дает возможность ранее реализованные вещи более сложным образом.

Привносит в код нашего будущего плагина все то что все мы так любим.
 - Мое субъективное видение проблем проблем WordPress;
 - ООП;
 - Многословность;
 - Быть может позднее статическое связывание;
 - Возможно кодогенирацию;
 - Навязывает зависимость от сторонних утилит.

Я ещё не определился с полным списком фитч и точно не уверен.
Документации на английском скорее всего не будет никогда.

##Фитчи##

 - [PSR-4 автозагрузка](http://www.php-fig.org/psr/psr-4/) классов;
 - Универсальная структура проекта;
 - Каркас для базового класса плагина;
 - Авторегистрация [WordPress виджетов](https://codex.wordpress.org/Widgets_API) при создании их класса;
 - Правильная [регистрация и подключение асертов](https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts) разом;
 - Автоподключение асертов изходя из названия файлов (css/javascript файлов);
 - Возможность облегчить перенос асертов в нижнюю часть страницы сайта;
 - Удобные алиасы хуков;
 - [Сборщик фронтенда](http://gulpjs.com/);
 - Базовый класс для облегчающий [AJAX запросы в WordPress](https://codex.wordpress.org/AJAX);
 - Обертка для легкого создания [шорткодов](https://codex.wordpress.org/Function_Reference/add_shortcode);
 - Возможно что то еще.

**Внимание** семантическое версионирование, между мажорными версиями совместимость точно будет ломаться. 

После установки нужно сделать `npm install` для установки gulp и плагинов к нему. 