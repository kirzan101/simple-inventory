<template>
  <b-modal id="modal-1" title="BootstrapVue">
    <p class="my-4">{{ itemName }}</p>
    <input type="text" @keypress="input" v-model="modalInput">
  </b-modal>
</template>

<script>
export default {
    props: {
        itemName: String
    },
    data() {
        return {
            modalInput: "",
            modalInputSecond: ""
        }
    },
    methods: {
        input() {
            this.modalInputSecond = this.modalInput;
            this.$emit('childInput', this.modalInput, this.modalInputSecond); //pass data from child to parent
        }
    }
}
</script>