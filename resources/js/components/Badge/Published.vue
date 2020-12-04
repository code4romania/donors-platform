<template>
    <base-badge
        :text="$t(`dashboard.status.${status}`)"
        :color="publishedStatusBadgeType"
    />
</template>

<script>
    export default {
        name: 'PublishedBadge',
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
