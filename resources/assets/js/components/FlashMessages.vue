<template>
    <div
        v-if="show && hasMessage"
        role="alert"
        class="fixed inset-x-0 bottom-0 z-50 w-full px-4 pb-8 md:px-12 lg:max-w-3xl lg:left-auto"
    >
        <div
            class="relative flex items-center px-4 py-5 pr-12 rounded-md shadow"
            :class="alertColor"
        >
            <svg-vue
                v-if="isSuccess"
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
                show: true,
            };
        },
        computed: {
            hasMessage() {
                return this.isSuccess || this.isError;
            },
            isSuccess() {
                return this.$page.props.flash.success !== null;
            },
            isError() {
                return (
                    this.$page.props.flash.error !== null ||
                    Object.keys(this.$page.props.errors).length > 0
                );
            },
            message() {
                if (this.isSuccess) {
                    return this.$page.props.flash.success;
                }

                if (this.isError) {
                    if (this.$page.props.flash.error !== null) {
                        return this.$page.props.flash.error;
                    } else {
                        let count = Object.keys(this.$page.props.errors).length;
                        return this.$tc('dashboard.event.errors', count, { count });
                    }
                }

                return null;
            },
            alertColor() {
                return this.isSuccess
                    ? 'text-green-500 bg-green-100'
                    : 'text-red-500 bg-red-100';
            },
            buttonColor() {
                return this.isSuccess
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
