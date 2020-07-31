<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('donors.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('donor.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{ $page.donor.name }}
        </template>

        <panel>
            <div
                class="grid gap-4 sm:grid-cols-3 md:col-gap-6 md:row-gap-8 md:grid-cols-5"
            >
                <div class="md:row-span-2">
                    <img
                        class="w-full"
                        src="https://images.unsplash.com/photo-1584441405886-bc91be61e56a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=300&h=300&q=80"
                        alt=""
                    />
                </div>

                <div class="sm:col-span-2 md:col-span-4">
                    <h2
                        class="text-2xl font-bold leading-tight md:text-3xl"
                        v-text="$page.donor.name"
                    />

                    <div v-if="$page.donor.hq" class="flex items-center">
                        <svg-vue
                            icon="Map/map-pin-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        <span v-text="$page.donor.hq" />
                    </div>
                </div>

                <div class="sm:col-span-3 md:col-span-2">
                    <strong class="text-lg" v-text="$page.donor.contact" />

                    <div
                        v-if="$page.donor.email"
                        class="flex items-center mt-1"
                    >
                        <svg-vue
                            icon="Business/at-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`mailto:${$page.donor.email}`"
                            class="hover:underline"
                            v-text="$page.donor.email"
                        />
                    </div>

                    <div
                        v-if="$page.donor.phone"
                        class="flex items-center mt-1"
                    >
                        <svg-vue
                            icon="Device/phone-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`tel:${$page.donor.phone}`"
                            class="hover:underline"
                            v-text="$page.donor.phone"
                        />
                    </div>
                </div>

                <div
                    class="sm:col-span-3 md:col-span-2"
                    v-if="$page.donor.areas.length"
                >
                    <strong class="text-lg" v-text="$t('model.field.areas')" />
                    <div class="flex items-center mt-1">
                        <svg-vue
                            icon="Design/focus-3-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        {{ $page.donor.areas.join(', ') }}
                    </div>
                </div>
            </div>
        </panel>

        <div class="grid gap-8 md:grid-cols-3">
            <panel class="md:col-span-2">a</panel>
            <panel title="Total Funding" icon="Weather/sun-fill">
                Total funding
            </panel>
        </div>
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';
    import FormInput from '@/Shared/Form/Input';
    import FormSelect from '@/Shared/Form/Select';
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormCheckboxGroup from '@/Shared/Form/CheckboxGroup';
    import FormButton from '@/Shared/Form/Button';
    import Panel from '@/Shared/Panel';

    export default {
        components: {
            Layout,
            FormInput,
            FormSelect,
            FormCheckbox,
            FormCheckboxGroup,
            FormButton,
            Panel,
        },
        metaInfo() {
            return {
                title: this.$page.donor.name,
            };
        },
        data() {
            return {
                form: {
                    name: null,
                    type: null,
                    hq: null,
                    contact: null,
                    email: null,
                    phone: null,
                    areas: [],
                },
            };
        },
    };
</script>
