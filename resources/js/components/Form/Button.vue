<template>
    <component
        :is="buttonComponent"
        class="relative px-6 py-2 font-semibold leading-snug tracking-wide text-center rounded shadow-md sm:w-auto focus:outline-none"
        :class="[buttonColor, buttonWidth, buttonDisabled]"
        :disabled="disabled"
        :href="href"
        v-bind="$attrs"
        @click="$emit('click')"
    >
        <slot />
    </component>
</template>

<script>
    import colors from '@/plugins/colors';

    export default {
        name: 'FormButton',
        props: {
            href: {
                type: [String, null],
                default: null,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            color: {
                type: String,
                default: 'blue',
                validator: (color) => colors.hasOwnProperty(color),
            },
            shade: {
                type: String,
                default: 'regular',
                validator: (shade) => ['light', 'regular', 'dark'].includes(shade),
            },
            fullWidth: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            buttonComponent() {
                return !this.href ? 'button' : 'inertia-link';
            },
            buttonWidth() {
                return this.fullWidth ? 'block' : 'inline-block';
            },
            buttonColor() {
                return [
                    colors[this.color][this.shade].base,
                    this.disabled || colors[this.color][this.shade].interact,
                ];
            },
            buttonDisabled() {
                return this.disabled
                    ? 'opacity-50 cursor-default'
                    : 'hover:shadow-lg focus:shadow-md';
            },
        },
    };
</script>
