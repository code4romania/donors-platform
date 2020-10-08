    <template>
    <div>
        <form-select id="currency" :options="currencies" v-model="currency" />
    </div>
</template>

<script>
    export default {
        name: 'CurrencySelect',
        computed: {
            currencies() {
                return this.$page.currencies;
            },
        },
        data() {
            return {
                currency: this.$page.currency,
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
