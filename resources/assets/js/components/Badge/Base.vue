<template>
    <span
        class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold leading-tight"
        :class="style"
        v-text="text"
    />
</template>

<script>
    import colors from '@/plugins/colors';

    export default {
        name: 'BaseBadge',
        props: {
            text: {
                type: String,
                required: true,
            },
            color: {
                type: String,
                default: 'gray',
                validator: (color) => colors.hasOwnProperty(color),
            },
            shade: {
                type: String,
                default: 'light',
                validator: (shade) => ['light', 'regular', 'dark'].includes(shade),
            },
        },
        computed: {
            style() {
                return colors[this.color][this.shade].base;
            },
        },
    };
</script>
