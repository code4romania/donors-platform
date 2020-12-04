<template>
    <div
        class="grid gap-6 px-4 py-5 bg-white rounded-sm shadow md:gap-8 md:grid-cols-3 sm:rounded-lg md:shadow-md sm:p-6"
    >
        <div class="md:col-span-1">
            <h3
                class="text-lg font-semibold leading-tight text-gray-900 md:text-xl"
                v-text="title"
            />
            <p
                class="mt-2 text-sm leading-snug text-gray-600"
                v-if="description"
                v-text="description"
            />
        </div>
        <div class="grid gap-6 md:col-span-2 md:gap-8 lg:grid-cols-2">
            <slot />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormPanel',
        props: {
            title: {
                type: String,
                required: true,
            },
            description: {
                type: String,
                required: false,
            },
        },
    };
</script>
