<template>
    <div
        v-if="show && type !== null"
        role="alert"
        class="fixed inset-x-0 bottom-0 z-50 w-full px-4 pb-8 md:px-12 lg:max-w-3xl lg:left-auto"
    >
        <div
            class="relative flex justify-between px-4 py-5 pr-12 rounded-md shadow"
            :class="alertColor"
        >
            <svg-vue
                v-if="type === 'success'"
                icon="System/checkbox-circle-fill"
                class="w-5 h-5 mr-2 fill-current"
            />
            <svg-vue
                v-else
                icon="System/error-warning-fill"
                class="w-5 h-5 mr-2 fill-current"
            />

            <span class="flex-1" v-text="message" />

            <button
                @click="show = false"
                class="absolute p-1 rounded focus:outline-none top-4 right-4"
                :class="buttonColor"
            >
                <svg-vue
                    icon="System/close-fill"
                    class="w-5 h-5 fill-current"
                />
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FlashMessages',
        data() {
            return {
                show: false,
            };
        },
        computed: {
            type() {
                if (this.$page.flash.success) {
                    return 'success';
                } else if (
                    this.$page.flash.error ||
                    Object.keys(this.$page.errors).length > 0
                ) {
                    return 'error';
                } else {
                    return null;
                }
            },
            message() {
                if (this.type === 'error') {
                    if (this.$page.flash.error !== null) {
                        return this.$page.flash.error;
                    } else {
                        let count = Object.keys(this.$page.errors).length;
                        return this.$tc('dashboard.event.errors', count, { count });
                    }
                } else if (this.type === 'success') {
                    return this.$page.flash.success;
                }
            },
            alertColor() {
                return this.type === 'success'
                    ? 'text-green-500 bg-green-100'
                    : 'text-red-500 bg-red-100';
            },
            textColor() {
                return this.type === 'success' ? 'text-green-800' : 'text-red-800';
            },
            buttonColor() {
                return this.type === 'success'
                    ? 'hover:bg-green-200 focus:bg-green-200'
                    : 'hover:bg-red-200 focus:bg-red-200';
            },
        },
        watch: {
            '$page.flash': {
                handler() {
                    this.show = true;
                },
                deep: true,
            },
        },
    };
</script>
