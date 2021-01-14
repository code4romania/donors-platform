function getTypeOf(value) {
    return toString
        .call(value)
        .match(/\[object (\w+)\]/)[1]
        .toLowerCase();
}

export default {
    typeof: value => getTypeOf(value),

    isArray: value => getTypeOf(value) === 'array',
    isObject: value => getTypeOf(value) === 'object',
    isFile: value => getTypeOf(value) === 'file',
    isBoolean: value => typeof value === 'boolean',

    formatAmount: value => (value !== null ? value.amount / 100 : null),
    clamp: (x, min, max) => Math.min(Math.max(x, min), max),
};
