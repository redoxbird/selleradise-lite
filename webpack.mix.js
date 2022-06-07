let mix = require("laravel-mix");
const ESLintPlugin = require("eslint-webpack-plugin");

mix.browserSync({
  proxy: "http://localhost:8010",
  files: ["**/*.php", "assets/dist/css/**/*.css", "assets/dist/js/**/*.js"],
  injectChanges: false,
  reloadDebounce: 300,
  port: 3001,
});

mix.setPublicPath("./assets/dist");
mix.disableSuccessNotifications();

mix.webpackConfig({
  plugins: [
    new ESLintPlugin({
      fix: true,
    }),
  ],
  module: {
    rules: [
      {
        test: /\.svg$/,
        use: [{ loader: "svg-inline-loader" }],
      },
    ],
  },
});

mix
  .js("assets/src/scripts/header.js", "assets/dist/js")
  .js("assets/src/scripts/app.js", "assets/dist/js")
  .vue()
  .js("assets/src/scripts/admin.js", "assets/dist/js")
  .sass("assets/src/sass/style.scss", "assets/dist/css")
  .sass("assets/src/sass/elementor-widgets.scss", "assets/dist/css")
  .options({
    processCssUrls: false,
    terser: {
      extractComments: false,
    },
  });
