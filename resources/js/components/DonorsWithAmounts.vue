<template>
    <div>
        <ul class="grid gap-y-8 md:gap-y-4">
            <li
                v-for="(item, index) in list"
                :key="index"
                class="flex items-start md:items-stretch"
            >
                <div class="grid flex-1 gap-4 md:grid-cols-2">
                    <form-select
                        :id="`${fieldName}.${index}.id`"
                        :label="$t('model.donor.singular') + ` #${index + 1}`"
                        :options="donors"
                        v-model="item.id"
                        option-value-key="id"
                        option-label-key="name"
                        required
                    />

                    <form-input
                        :id="`${fieldName}.${index}.amount`"
                        type="number"
                        :label="$t('field.contribution')"
                        v-model.number="item.amount"
                        :suffix="currency"
                        min="0"
                        required
                    />
                </div>

                <div class="flex items-center w-6 mt-5 ml-4">
                    <button
                        type="button"
                        class="flex-shrink-0 text-gray-300 hover:text-red-500 focus:outline-none focus:text-red-500"
                        @click="removeAt(index)"
                    >
                        <svg-vue
                            icon="System/delete-bin-line"
                            class="w-6 h-6 fill-current"
                        />
                    </button>
                </div>
            </li>
        </ul>

        <div class="mt-6 space-x-3">
            <form-button type="button" color="blue" shade="light" @click="add">
                {{
                    $t('dashboard.action.createModel', {
                        model: $t('model.donor.singular').toLowerCase(),
                    })
                }}
            </form-button>

            <form-input-error :id="fieldName" />
        </div>
    </div>
</template>

<script>
    import utils from '@/utils';

    export default {
        name: 'DonorsWithAmounts',
        props: {
            fieldName: {
                type: String,
                default: 'donors',
            },
            currency: {
                type: String,
                default: null,
            },
            maxAmount: {
                type: Number,
                default: 0,
            },
            donors: {
                type: Array,
                default: () => [],
            },
            value: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                list: [],
            };
        },
        computed: {
            remainingAmount() {
                let total = this.list.reduce(
                    (total, item) => total + item.amount,
                    0
                );

                return Math.max(0, this.maxAmount - total);
            },
        },
        methods: {
            removeAt(index) {
                this.list.splice(index, 1);
            },
            add() {
                this.list.push({
                    id: null,
                    amount: this.remainingAmount,
                });
            },
        },
        watch: {
            value: {
                immediate: true,
                handler(value) {
                    if (!utils.isArray(value)) {
                        return;
                    }

                    this.list = value;
                },
            },
            list(value) {
                this.$emit('input', value);
            },
        },
    };
</script>
