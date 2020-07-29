<template>
    <layout>
        <template v-slot:title>
            Index
        </template>

        <inertia-link class="btn-indigo" href="/404">
            404 error
        </inertia-link>
    </layout>
</template>

<script>
    import Layout from '@/Shared/Layout/Default';

    export default {
        components: {
            Layout,
        },
        metaInfo: {
            title: 'Dashboard',
        },
    };
</script>
