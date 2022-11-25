<template>
    <div id="modal" class="modal fade" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('actions.cancel') }}</button>
                    <button @click="confirm" class="btn btn-primary">{{ $t('actions.save') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Modal} from 'bootstrap';

export default {
    props: {
        visible: Boolean,
        title: String,
    },
    data() {
        return {
            modal: null,
        }
    },
    mounted() {
        this.modal = new Modal(this.$refs.modal);
        console.log(this.modal._element);
        this.modal._element.addEventListener('hidden.bs.modal', () => {
            this.$emit("close");
        });
    },
    watch: {
        visible(state) {
            state ? this.modal.show() : this.modal.hide();
        }
    },
    methods: {
        confirm() {
          this.$emit("confirm");
        },
    },
}
</script>

<style scoped>

</style>
