<template>
    <div role="alert" class="flex items-center p-4 rounded-md" :class="style">
        <div v-if="icon" class="shrink-0 mt-0.5">
            <svg-vue :icon="icon" class="w-4 h-4 fill-current" />
        </div>
        <span class="ml-3 leading-tight">
            <slot />
        </span>
    </div>
</template>

<script>
    export default {
        name: 'Alert',
        props: {
            type: {
                type: String,
                default: 'success',
            },
            icon: {
                type: [String, null],
                default: null,
            },
        },
        computed: {
            style() {
                switch (this.type) {
                    case 'success':
                        return 'bg-green-100 text-green-800';
                        break;

                    case 'warning':
                        return 'bg-yellow-100 text-yellow-800';
                        break;

                    case 'error':
                        return 'bg-red-100 text-red-800';
                        break;
                }
            },
        },
    };
</script>
