<template>
    <span class="mt-2 text-sm text-red-600" role="alert" v-text="message" />
</template>

<script>
    export default {
        props: {
            message: {
                type: [String, null],
                default: null,
            },
        },
    };
</script>
