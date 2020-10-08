<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
        />

        <dropdown
            button-class="w-full text-left form-select"
            @close="$emit('input', checked)"
        >
            <div class="flex justify-between">
                <span
                    class="flex-1 break-all min-h-6"
                    :class="{ truncate: showCount }"
                    v-html="selectedLabel"
                />
                <span
                    v-if="showCount && checked.length"
                    class="flex-shrink-0 ml-2 text-gray-600"
                    v-text="`(${checked.length})`"
                />
            </div>

            <ul slot="dropdown">
                <li
                    v-for="(option, index) in options"
                    :key="index"
                    :class="indentWithDepth(option)"
                >
                    <label class="flex w-full px-4 py-2 cursor-pointer">
                        <input
                            type="checkbox"
                            class="w-4 h-4 mt-1 mr-2 text-blue-500 duration-150 ease-in-out transition-color form-checkbox"
                            :value="option[optionValueKey] || option"
                            v-model="checked"
                        />
                        {{ option[optionLabelKey] || option }}
                    </label>
                </li>
            </ul>

            <form-input-error :id="id" />
        </dropdown>
    </div>
</template>

<script>
    import map from 'lodash/map';

    export default {
        name: 'FormSelectMultiple',
        inheritAttrs: false,
        props: {
            label: {
                type: [String, null],
                default: null,
            },
            placeholder: {
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
            multiple: {
                type: Boolean,
                default: false,
            },
            showCount: {
                type: Boolean,
                default: false,
            },
            showSelected: {
                type: Boolean,
                default: false,
            },
            errors: {
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
                checked: [],
            };
        },
        computed: {
            selectedLabel() {
                if (this.showSelected) {
                    return map(
                        this.options.filter((o) => this.checked.includes(o.id)),
                        'name'
                    ).join(', ');
                }

                if (this.placeholder) {
                    return this.placeholder;
                }
            },
        },
        methods: {
            indentWithDepth(domain) {
                return ['', 'pl-6', 'pl-12', 'pl-18'][domain.depth];
            },
        },
        watch: {
            value: {
                immediate: true,
                handler: function (value) {
                    this.checked = value;
                },
            },
        },
    };
</script>
