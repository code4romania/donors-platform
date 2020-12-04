<template>
    <component :is="withPanel ? 'panel' : 'div'">
        <dl class="leading-tight">
            <dt class="mb-1 text-sm text-gray-500" v-text="title" />

            <dd
                class="font-semibold text-gray-900"
                :class="sizeClass"
                v-text="formattedNumber"
            />
        </dl>

        <template #footer v-if="readMoreLink">
            <inertia-link :href="readMoreLink" v-text="readMoreLabel" />
        </template>
    </component>
</template>

<script>
    export default {
        name: 'StatsCard',
        props: {
            number: {
                type: [Number, String, null],
                default: null,
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
            withPanel: {
                type: Boolean,
                default: true,
            },
            size: {
                type: String,
                default: 'lg',
            },
        },
        computed: {
            formattedNumber() {
                return this.isNumeric(this.number)
                    ? this.$n(+this.number)
                    : this.number;
            },
            sizeClass() {
                return this.size === 'lg' ? 'text-2xl' : 'text-base';
            },
        },
        methods: {
            isNumeric: (n) => !isNaN(parseFloat(n)) && isFinite(n),
        },
    };
</script>
