<template>
    <p class="text-sm font-normal leading-tight text-gray-500" v-text="text" />
</template>

<script>
    export default {
        name: 'FormHelp',
        props: {
            text: {
                type: String,
                default: null,
            },
        },
    };
</script>
