<template>
    <div class="relative" v-click-away="hide">
        <button
            type="button"
            @click="toggle"
            :class="buttonClass"
            aria-haspopup="true"
        >
            <slot />
        </button>

        <transition
            enter-active-class="transition-opacity duration-150 ease-out"
            enter-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition-opacity duration-75 ease-in"
            leave-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div v-if="open" ref="dropdown">
                <slot name="dropdown" />
            </div>
        </transition>
    </div>
</template>

<script>
    import { createPopper } from '@popperjs/core';

    export default {
        name: 'Dropdown',
        props: {
            placement: {
                type: String,
                default: 'bottom-end',
            },
            buttonClass: {
                type: String,
                default: '',
            },
        },
        data() {
            return {
                open: false,
            };
        },
        methods: {
            show() {
                this.open = true;
            },
            hide() {
                this.open = false;
            },
            toggle() {
                this.open = !this.open;
            },
        },
        computed: {
            popperOptions() {
                const preventOverflow = {
                    name: 'preventOverflow',
                    options: {
                        altBoundary: true,
                    },
                };

                return {
                    placement: this.placement,
                    modifiers: [preventOverflow],
                };
            },
        },
        watch: {
            open(open) {
                if (open) {
                    this.$nextTick(() => {
                        this.popper = createPopper(
                            this.$el,
                            this.$refs.dropdown,
                            this.popperOptions
                        );
                    });
                } else if (this.popper) {
                    setTimeout(() => this.popper.destroy(), 100);
                }
            },
        },
        mounted() {
            document.addEventListener('keydown', (e) => {
                if (e.keyCode === 27) {
                    this.hide();
                }
            });
        },
    };
</script>
