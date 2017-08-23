const mix = require('laravel-mix');

mix.js("resources/assets/js/util.js", "public/js")
    .copy("resources/assets/css/util.css", "public/css")
    .copy("resources/assets/css/main.css", "public/css");