let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
	.options({
		processCssUrls: false
	})
	.sass('resources/assets/sass/new-age.scss', 'public/css');

mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts');
mix.copyDirectory('node_modules/simple-line-icons/fonts', 'public/fonts');

// move to scss
mix.styles([
	'resources/assets/css/new-age.css',
], 'public/css/all.css');

mix.browserSync('http://localhost/blocklyapp/');
if (mix.inProduction()) {
	mix.version();
}

