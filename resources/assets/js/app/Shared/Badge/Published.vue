<template>
    <base-badge
        :text="$t(`dashboard.status.${status}`)"
        :color="publishedStatusBadgeType"
    />
</template>

<script>
    import BaseBadge from '@/Shared/Badge/Base';

    export default {
        components: {
            BaseBadge,
        },
        props: {
            status: {
                type: String,
                required: true,
            },
        },
        computed: {
            publishedStatusBadgeType() {
                return this.status === 'published' ? 'green' : 'gray';
            },
        },
    };
</script>
