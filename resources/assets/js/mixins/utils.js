export default {
    methods: {
        isObject: value => value !== null && value === Object(value),
        isFile: value => value instanceof File,

        formatAmount: value => (value !== null ? value.amount / 100 : null),
        clamp: (x, min, max) => Math.min(Math.max(x, min), max),
    },
};
