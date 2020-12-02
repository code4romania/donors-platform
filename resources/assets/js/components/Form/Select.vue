<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
        />

        <treeselect
            v-model="dataSelected"
            :options="options"
            :flat="true"
            :normalizer="normalizer"
            class="block w-full"
            v-bind="$attrs"
            @deselect="deselect"
            @input="input"
            @close="$emit('input', dataSelected)"
        />

        <form-input-error :id="id" />
    </div>
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';

    export default {
        name: 'FormSelect',
        inheritAttrs: false,
        components: {
            Treeselect,
        },
        props: {
            label: {
                type: [String, null],
                default: null,
            },
            id: {
                type: String,
                required: true,
            },
            options: {
                type: Array,
                default: () => [],
            },
            optionValueKey: {
                type: String,
                default: 'value',
            },
            optionLabelKey: {
                type: String,
                default: 'label',
            },
            optionPlaceholder: {
                type: [String, null],
                default: null,
            },
            errors: {
                type: Array,
                default: () => [],
            },
            value: {},
        },
        data() {
            return {
                dataSelected: [],
            };
        },
        methods: {
            optionValue(option) {
                return option[this.optionValueKey] || option;
            },
            optionLabel(option) {
                return option[this.optionLabelKey] || option;
            },
            normalizer(node) {
                let item = {
                    id: this.optionValue(node),
                    label: this.optionLabel(node),
                };

                if (node.children) {
                    item.children = node.children;
                }

                return item;
            },
            deselect(e) {
                this.dataSelected = this.dataSelected.filter(
                    (x) => x != this.optionValue(e)
                );
            },
            input(e) {
                if (this.$attrs.multiple) {
                    return;
                }

                this.$emit('input', this.dataSelected);
            },
        },
        watch: {
            value: {
                immediate: true,
                handler: function (newValue) {
                    if (typeof newValue !== 'undefined') {
                        this.dataSelected = newValue;
                    }
                },
            },
        },
    };
</script>


<style>
    .vue-treeselect__control {
        height: 42px;
    }

    .vue-treeselect__placeholder,
    .vue-treeselect__single-value {
        color: inherit;
        line-height: 40px;
    }
</style>
