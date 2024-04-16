<template>
    <div>
        <Navbar />
        <h1>This is Index Inventory</h1>

        <b-container fluid>
            <b-button 
                v-b-modal.inventory-form-modal
                class="my-3"
                variant="success"
                @click="add">
                Add
            </b-button>

            <b-table :fields="fields" striped hover :items="inventories"></b-table>      
            <FormInventoryModal
                v-if="clickedItem"
            />
        </b-container>
    </div>
</template>

<script>
import Navbar from '../../Navbar.vue';
import FormInventoryModal from './FormInventoryModal.vue';

export default {
    props: {
        inventories: Array,
        meta: Object,
    },
    components: {
        Navbar,
        FormInventoryModal,
    },
    data() {
        return {
            fields: ["name", "description", "batch_number", "item_id", "action"],
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
        add() {
            console.log("add");
            console.log(this.clickedItem);
            this.clickedItem = true;
        },
    }
}
</script>