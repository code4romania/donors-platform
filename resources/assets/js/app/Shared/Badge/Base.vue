<template>
    <span
        class="inline-flex px-2.5 py-0.5 rounded-full text-sm font-semibold leading-tight"
        :class="style"
        v-text="text"
    />
</template>

<script>
    export default {
        props: {
            text: {
                type: String,
                required: true,
            },
            color: {
                type: String,
                default: 'gray',
            },
        },
        computed: {
            style() {
                let colors = {
                    gray: 'bg-gray-100 text-gray-800',
                    red: 'bg-red-100 text-red-800',
                    orange: 'bg-orange-100 text-orange-800',
                    yellow: 'bg-yellow-100 text-yellow-800',
                    green: 'bg-green-100 text-green-800',
                    teal: 'bg-teal-100 text-teal-800',
                    blue: 'bg-blue-100 text-blue-800',
                    indigo: 'bg-indigo-100 text-indigo-800',
                    purple: 'bg-purple-100 text-purple-800',
                    pink: 'bg-pink-100 text-pink-800',
                };

                return colors[this.color] || null;
            },
        },
    };
</script>
