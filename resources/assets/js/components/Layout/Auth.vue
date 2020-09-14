<template>
    <div
        class="flex flex-col justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8"
    >
        <div class="text-center sm:mx-auto sm:w-full sm:max-w-md">
            <a href="/" class="inline-block">
                <Logo class="w-auto h-8 mx-auto text-gray-900 md:h-12" />
            </a>
        </div>

        <div class="grid w-full mx-auto mt-8 gap-y-4 sm:max-w-md">
            <div class="px-4 sm:px-8">
                <h1 class="text-xl font-bold leading-tight text-gray-900">
                    <slot name="title" />
                </h1>
            </div>

            <slot name="message" class="mb-4" />
            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-md shadow sm:p-8"
            >
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'LayoutAuth',
    };
</script>
