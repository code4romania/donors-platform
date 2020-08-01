<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('donors.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('dashboard.model.donor.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{ donor.name }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button
                    color="blue"
                    :href="$route('donors.edit', { donor: donor.id })"
                >
                    {{ $t('donor.edit') }}
                </form-button>
            </div>
        </template>

        <panel>
            <div
                class="grid gap-4 sm:grid-cols-3 md:col-gap-6 md:row-gap-8 md:grid-cols-5"
            >
                <div class="md:row-span-2">
                    <div class="relative border aspect-ratio-1/1">
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <img class="w-full" :src="donor.logo_url" alt="" />
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 md:col-span-4">
                    <h2
                        class="text-2xl font-bold leading-tight md:text-3xl"
                        v-text="donor.name"
                    />

                    <div v-if="donor.hq" class="flex items-center">
                        <svg-vue
                            icon="Map/map-pin-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        <span v-text="donor.hq" />
                    </div>
                </div>

                <div class="sm:col-span-3 md:col-span-2">
                    <strong class="text-lg" v-text="donor.contact" />

                    <div v-if="donor.email" class="flex items-center mt-1">
                        <svg-vue
                            icon="Business/at-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`mailto:${donor.email}`"
                            class="hover:underline"
                            v-text="donor.email"
                        />
                    </div>

                    <div v-if="donor.phone" class="flex items-center mt-1">
                        <svg-vue
                            icon="Device/phone-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`tel:${donor.phone}`"
                            class="hover:underline"
                            v-text="donor.phone"
                        />
                    </div>
                </div>

                <div
                    class="sm:col-span-3 md:col-span-2"
                    v-if="donor.areas.length"
                >
                    <strong
                        class="text-lg"
                        v-text="$t('dashboard.field.areas')"
                    />
                    <div class="flex items-center mt-1">
                        <svg-vue
                            icon="Design/focus-3-line"
                            class="w-4 h-4 mr-1 text-gray-500 fill-current"
                        />

                        {{ donor.areas.join(', ') }}
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
        props: {
            donor: Object,
        },
        metaInfo() {
            return {
                title: this.donor.name,
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
