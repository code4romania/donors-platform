<template>
    <component
        :is="buttonComponent"
        class="relative px-6 py-2 font-semibold leading-snug tracking-wide text-center shadow-md sm:w-auto hover:shadow-lg focus:outline-none focus:shadow-md"
        :class="[buttonColor, buttonWidth]"
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
                switch (this.color) {
                    case 'blue':
                        return 'text-white bg-blue-500 focus:bg-blue-600';
                        break;

                    case 'yellow':
                        return 'text-black bg-yellow-300 focus:bg-yellow-200';
                        break;

                    case 'red':
                        return 'text-white bg-red-500 focus:bg-red-600';
                        break;

                    case 'green':
                        return 'text-white bg-green-500 focus:bg-green-600';
                        break;

                    case 'black':
                        return 'text-white bg-black focus:bg-gray-800';
                        break;

                    case 'gray':
                        return 'text-white bg-gray-500 focus:bg-gray-600';
                        break;

                    case 'white':
                        return 'border bg-white focus:bg-gray-50';
                        break;
                }
            },
        },
    };
</script>
