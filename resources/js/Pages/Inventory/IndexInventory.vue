<template>
    <div>
        <Navbar />
        <h1>This is Index Inventory</h1>

        <b-container fluid>
            <b-button v-b-modal.inventory-form-modal>
                Add
            </b-button>

            <b-table :fields="fields" striped hover :inventories="inventories"></b-table>      
        </b-container>
    </div>
</template>

<script>
import Navbar from '../../Navbar.vue';

export default {
    props: {
        inventories: Array,
        meta: Object,
    },
    components:{
        Navbar
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
    }
}
</script>