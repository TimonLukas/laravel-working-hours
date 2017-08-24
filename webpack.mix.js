const mix = require('laravel-mix');

mix.js("resources/assets/js/util.js", "public/js")
    .styles([
        "resources/assets/css/util.css",
        "resources/assets/css/main.css",
    ], "public/css/style.css");