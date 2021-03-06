const mix = require('laravel-mix');
require('laravel-mix-svg-vue');
require('laravel-mix-bundle-analyzer');

mix.extend(
    'translations',
    new (class {
        webpackRules() {
            return {
                test: path.resolve('resources/lang/index.js'),
                loader: `@kirschbaum-development/laravel-translations-loader/?parameters={$1}`,
            };
        }
    })()
);

mix.options({
    // extractVueStyles: true,
    hmrOptions: {
        host: 'platformadonatorilor.test',
        port: '8080',
    },
});

mix.config.fileLoaderDirs.fonts = 'assets/fonts';

mix.webpackConfig({
    devtool: mix.inProduction() ? 'none' : 'source-map',
    resolve: {
        alias: {
            vue$: 'vue/dist/vue.runtime.esm.js',
            '@': path.resolve('resources/js'),
            '~': path.resolve('resources'),
        },
    },
});

if (mix.inProduction()) {
    mix.version();
}

// if (mix.isWatching()) {
//     mix.bundleAnalyzer();
// }

mix.js('resources/js/app.js', 'public/assets')
    .postCss('resources/css/app.pcss', 'public/assets', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .translations()
    .svgVue({
        svgPath: 'node_modules/remixicon/icons',
        extract: false,
        svgoSettings: [
            { removeXMLNS: true },
            { removeTitle: true },
            { removeViewBox: false },
            { removeDimensions: true },
        ],
    })
    .copyDirectory('resources/svg', 'public/assets/svg')
    .copyDirectory('resources/images', 'public/assets/images')
    .extract();
