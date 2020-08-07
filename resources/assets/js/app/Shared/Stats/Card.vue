<template>
    <panel>
        <dl class="leading-tight truncate">
            <dt class="mb-1 text-sm text-gray-500" v-text="title" />

            <dd
                class="text-3xl font-semibold text-gray-900"
                v-text="$n(number)"
            />
        </dl>

        <template v-slot:footer v-if="readMoreLink">
            <inertia-link :href="readMoreLink" v-text="readMoreLabel" />
        </template>
    </panel>
</template>

<script>
    import Panel from '@/Shared/Panel.vue';

    export default {
        components: {
            Panel,
        },
        props: {
            number: {
                type: [Number, null],
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
        },
    };
</script>
