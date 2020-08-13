const mix = require('laravel-mix');
require('laravel-mix-svg-vue');

mix.extend(
    'translations',
    new (class {
        webpackRules() {
            return {
                test: path.resolve('resources/lang/index.js'),
                loader: `@kirschbaum-development/laravel-translations-loader/php?parameters={$1}`,
            };
        }
    })()
);

mix.options({
    hmrOptions: {
        host: 'donors.test',
        port: '8080',
    },
});

mix.config.fileLoaderDirs.fonts = 'fonts';

mix.webpackConfig({
    devtool: mix.config.production ? 'none' : 'source-map',
    resolve: {
        alias: {
            vue$: 'vue/dist/vue.runtime.esm.js',
            '@': path.resolve('resources/assets/js'),
            '~': path.resolve('resources'),
        },
    },
});

if (mix.config.production) {
    mix.version();
}

mix.setPublicPath('public/assets')
    .setResourceRoot('/')

    .js('resources/assets/js/app.js', 'public/assets')
    .postCss('resources/assets/css/app.pcss', 'public/assets', [
        require('postcss-import'),
        require('tailwindcss')('./tailwind.config.js'),
        require('postcss-nested')({
            bubble: ['screen'],
        }),
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
    .extract();
