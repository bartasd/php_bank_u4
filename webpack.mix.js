let mix = require("laravel-mix");

mix
  .sass("resources/scss/main.scss", "public/")
  .js("resources/js/main.js", "public/");
