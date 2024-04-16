<template>
    <div>
        <Navbar />
        <h1>Items</h1>
        
        <b-container fluid>
            <b-button
                v-b-modal.item-form-modal
                class="my-3"
                variant="success"
                @click="add"
                >Add</b-button
            >

            <b-table :fields="fields" striped hover :items="items">
                <template #cell(action)="data">
                    <b-button
                        @click="selectItem(data.item)"
                        v-b-modal.item-form-modal
                        variant="primary"
                        >Update</b-button
                    >
                </template>
            </b-table>

            <FormItemModal
                v-if="clickedItem"
                :item="selectedItem"
                :formType="formType"
                @toggleEmpty="emptyFields"
            />
        </b-container>
    </div>
</template>

<script>
import Navbar from "../../Navbar.vue";
import FormItemModal from "./FormItemModal.vue";

export default {
    props: {
        items: Array,
        meta: Object,
    },
    components: {
        Navbar,
        FormItemModal,
    },
    data() {
        return {
            fields: ["name", "description", "model", "brand", "action"],
            selectedItem: {
                name: "",
                description: "",
                model: "",
                brand: "",
            },
            clickedItem: false,
            formType: "ADD",
        };
    },
    methods: {
        selectItem(item) {
            console.log(item, "item here");
            this.selectedItem = item;
            this.clickedItem = !this.clickedItem;
            this.formType = "UPDATE";
        },
        add() {
            this.clickedItem = !this.clickedItem;
            this.formType = "ADD";
        },
        emptyFields() {
            console.log('here1!!')
            this.selectedItem = Object.assign({}, "");
        },
    },
};
</script>
