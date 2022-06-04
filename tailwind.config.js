module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: [
                    'Titillium Web',
                    'Helvetica Neue',
                    'Helvetica',
                    'Arial',
                    'sans-serif',
                ],
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
        columnCount: [1, 2, 3, 4],
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
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('tailwindcss-multi-column')(),
    ],
    content: [
        'resources/views/**/*.blade.php',
        'resources/js/**/*.js',
        'resources/js/**/*.vue',
    ],
};
