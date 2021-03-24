const mix = require('laravel-mix');
const path = require('path');

require('laravel-mix-svg-vue');
require('laravel-mix-bundle-analyzer');
require('laravel-mix-valet');

mix.extend(
    'translations',
    new (class {
        webpackRules() {
            return {
                test: path.resolve('resources/lang/index.js'),
                use: [
                    {
                        loader: `@kirschbaum-development/laravel-translations-loader/?parameters={$1}`,
                    },
                ],
            };
        }
    })()
);

//////

if (mix.inProduction()) {
    mix.version();
}

if (mix.isWatching()) {
    mix.bundleAnalyzer({ openAnalyzer: false });
}

mix.valet('platformadonatorilor.test')
    .translations()
    .alias({
        '@': path.resolve('resources/js'),
        '~': path.resolve('resources'),
    })
    .options({
        fileLoaderDirs: {
            fonts: 'assets/fonts',
        },
    });

mix.js('resources/js/app.js', 'public/assets')
    .js('resources/js/public.js', 'public/assets')
    .vue({ version: 2 })
    .postCss('resources/css/app.pcss', 'public/assets', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
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
    .copyDirectory('resources/images', 'public/assets/images');
