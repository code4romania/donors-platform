module.exports = {
    future: {
        purgeLayersByDefault: true,
        removeDeprecatedGapUtilities: true,
    },
    theme: {
        container: {
            padding: '1.25rem',
            center: true,
        },
        extend: {
            fontFamily: {
                sans: [
                    'Titillium Web',
                    'Helvetica Neue',
                    'Helvetica',
                    'Arial',
                    'sans-serif',
                ],
                mono: ['Courier', 'monospace'],
            },
            minWidth: theme => ({
                ...theme('spacing'),
            }),
            minHeight: theme => ({
                ...theme('spacing'),
                '75vh': '75vh',
            }),
            maxHeight: theme => ({
                ...theme('spacing'),
                '75vh': '75vh',
            }),
        },
        textStyles: theme => ({
            embed: {
                position: 'relative',
                overflow: 'hidden',
                display: 'block',
                width: '100%',
                padding: 0,

                'iframe, video': {
                    position: 'absolute',
                    height: '100%',
                    width: '100%',
                    left: 0,
                    top: 0,
                },
            },
        }),
        // This should match the aspect raio values defined in config/cms/embeds.php
        aspectRatio: {
            '1/1': [1, 1],
            '5/4': [5, 4],
            '4/3': [4, 3],
            '3/2': [3, 2],
            '5/3': [5, 3],
            '16/9': [16, 9],
            '2/1': [2, 1],
            '3/1': [3, 1],
            '5/6': [5, 6],
            '4/5': [4, 5],
            '3/4': [3, 4],
            '2/3': [2, 3],
            '3/5': [3, 5],
            '9/16': [9, 16],
            '1/2': [1, 2],
            '1/3': [1, 3],
        },
        columnCount: [1, 2, 3, 4],
        columnGap: {
            // will fallback to 'gap' || 'gridGap' values
            // sm: '1rem',
            // md: '1.5rem',
            // lg: '2rem',
        },
        columnWidth: {
            // sm: '120px',
            // md: '240px',
            // lg: '360px',
        },
        columnRuleColor: false, // will fallback to `borderColor` values
        columnRuleWidth: false, // will fallback to `borderWidth` values
        columnRuleStyle: [
            'none',
            'hidden',
            'dotted',
            'dashed',
            'solid',
            'double',
            'groove',
            'ridge',
            'inset',
            'outset',
        ],
        columnFill: ['auto', 'balance', 'balance-all'],
        columnSpan: ['none', 'all'],
    },
    variants: {
        aspectRatio: ['responsive'],
        backgroundColor: [
            'responsive',
            'hover',
            'focus',
            'group-hover',
            'group-focus',
            'focus-within',
        ],
    },
    plugins: [
        //
        require('tailwindcss-aspect-ratio'),
        require('@tailwindcss/ui'),
        require('@tailwindcss/typography'),
        require('tailwindcss-multi-column')(),
    ],
    purge: {
        content: [
            //
            'resources/views/**/*.blade.php',
            'resources/assets/js/**/*.js',
            'resources/assets/js/**/*.vue',
        ],
        options: {
            whitelist: ['rich-text', 'ck-content'],
            whitelistPatterns: [/^aspect-ratio-/],
        },
    },
};
