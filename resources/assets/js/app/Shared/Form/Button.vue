<template>
    <component
        :is="buttonComponent"
        class="relative px-6 py-2 font-semibold leading-snug tracking-wide text-center rounded shadow-md sm:w-auto focus:outline-none"
        :class="[buttonColor, buttonWidth, buttonDisabled]"
        :href="href"
        v-bind="$attrs"
    >
        <slot />
    </component>
</template>

<script>
    export default {
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
                default: '',
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
                let colors = {
                    gray: {
                        base: 'text-white bg-gray-500',
                        interact: 'focus:bg-gray-600',
                    },
                    red: {
                        base: 'text-white bg-red-500',
                        interact: 'focus:bg-red-600',
                    },
                    orange: {
                        base: 'text-white bg-orange-500',
                        interact: 'focus:bg-orange-600',
                    },
                    yellow: {
                        base: 'text-black bg-yellow-300',
                        interact: 'focus:bg-yellow-400',
                    },
                    green: {
                        base: 'text-white bg-green-500',
                        interact: 'focus:bg-green-600',
                    },
                    teal: {
                        base: 'text-white bg-teal-500',
                        interact: 'focus:bg-teal-600',
                    },
                    blue: {
                        base: 'text-white bg-blue-500',
                        interact: 'focus:bg-blue-600',
                    },
                    indigo: {
                        base: 'text-white bg-indigo-500',
                        interact: 'focus:bg-indigo-600',
                    },
                    purple: {
                        base: 'text-white bg-purple-500',
                        interact: 'focus:bg-purple-600',
                    },
                    pink: {
                        base: 'text-white bg-pink-500',
                        interact: 'focus:bg-pink-600',
                    },
                };

                if (!colors.hasOwnProperty(this.color)) {
                    return;
                }

                return [
                    colors[this.color].base,
                    this.disabled || colors[this.color].interact,
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
