<template>
    <div>
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
