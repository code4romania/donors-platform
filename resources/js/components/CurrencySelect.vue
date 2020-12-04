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
            return {
                currency: this.$page.props.currency,
            };
        },
        methods: {
            submit() {
                let url = new URL(window.location);

                url.searchParams.set('currency', this.currency);

                this.$inertia.get(decodeURI(url.toString()));
            },
        },

        watch: {
            currency() {
                this.submit();
            },
        },
    };
</script>
