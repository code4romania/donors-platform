<template>
    <layout>
        <template v-slot:title>
            Donors
        </template>
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';

    export default {
        components: {
            Layout,
        },
        metaInfo: {
            title: 'Donors',
        },
    };
</script>
