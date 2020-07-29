<template>
    <header class="grid gap-8 md:grid-cols-2">
        <h1 class="text-2xl font-semibold text-gray-900" v-text="title" />

        <portal-target name="actions" class="flex justify-end space-x-4" />
    </header>
</template>

<script>
    export default {
        props: {
            title: String,
        },
    };
</script>
