<template>
    <div v-if="!isHidden">
        <form-select
            id="currency"
            :options="currencies"
            v-model="currency"
            :clearable="false"
        />
    </div>
</template>

<script>
    export default {
        name: 'CurrencySelect',
        computed: {
            currencies() {
                return this.$page.props.currencies;
            },
            isHidden() {
                return [
                    'grants.show',
                    'grants.create',
                    'grants.edit',
                    'projects.show',
                    'projects.create',
                    'projects.edit',
                ].includes(this.$route().current());
            },
        },
        data() {
            return this.$inertia.form({
                currency: this.$page.props.currency,
            });
        },
        watch: {
            currency() {
                this.post(this.$route('currency.select'));
            },
        },
    };
</script>
