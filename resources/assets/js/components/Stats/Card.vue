<template>
    <panel>
        <dl class="leading-tight truncate">
            <dt class="mb-1 text-sm text-gray-500" v-text="title" />

            <dd
                class="text-2xl font-semibold text-gray-900"
                v-text="formattedNumber"
            />
        </dl>

        <template v-slot:footer v-if="readMoreLink">
            <inertia-link :href="readMoreLink" v-text="readMoreLabel" />
        </template>
    </panel>
</template>

<script>
    export default {
        name: 'StatsCard',
        props: {
            number: {
                type: [Number, String, null],
                required: true,
            },
            title: {
                type: [String, null],
                default: null,
            },
            readMoreLink: {
                type: [String, null],
                default: null,
            },
            readMoreLabel: {
                type: [String, null],
                default: null,
            },
        },
        computed: {
            formattedNumber() {
                return this.isNumeric(this.number)
                    ? this.$n(+this.number)
                    : this.number;
            },
        },
        methods: {
            isNumeric: (n) => !isNaN(parseFloat(n)) && isFinite(n),
        },
    };
</script>
