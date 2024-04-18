<template>
    <div>
        <Navbar />
        <h1>Inventories</h1>

        <b-container fluid>
            <b-button 
                v-b-modal.inventory-form-modal
                class="my-3"
                variant="success"
                @click="add"
                >Add</b-button>
            
            <b-pagination-nav :link-gen="linkGen" :number-of-pages="totalPages" use-router></b-pagination-nav>

            <p class="mt-3">Current Page: {{ currentPage }}</p>

            <b-table id="my-table" :fields="fields" striped hover :items="inventories">
                <template #cell(action)="data">
                    <b-button
                        @click="selectInventory(data.item)"
                        v-b-modal.inventory-form-modal
                        variant="primary"
                        >Update</b-button>
                </template>
            </b-table>      
            <FormInventoryModal
                v-if="clickedItem"
                :inventory="selectedInventory"
                :items="items"
                :formType="formType"
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
        items: Array,
        rows: Number,
        meta: Object,
    },
    components: {
        Navbar,
        FormInventoryModal,
    },
    data() {
        return {
            fields: ["name", "description", "batch_number", "serial_number", "item_id", "action"],
            selectedInventory: {
                name: "",
                description: "",
                batch_number: "",
                serial_number: "",
                item_id: "",
            },
            clickedItem: false,
            formType: "ADD",
            currentPage: this.meta.current_page,
        };
    },
    methods: {
        selectInventory(inventory) {
            console.log(inventory, "item here");
            this.selectedInventory = inventory;
            this.clickedItem = true;
            this.formType = "UPDATE";
        },
        add() {
            console.log("add");
            console.log(this.clickedItem);
            this.clickedItem = true;
            this.formType = "ADD";
        },
        linkGen(pageNum) {
            return pageNum === 1 ? '?' : `?page=${pageNum}`
        },
    },
    computed: {
        totalPages() {
            console.log(this.items);
            console.log("Meta:", this.meta.per_page);
            console.log("Rows:", this.rows);
            console.log("Pages: ", Math.ceil(this.rows / this.meta.per_page));
            if (Math.ceil(this.rows / this.meta.per_page) == 0) {
                return 1;
            }
            else{
                return Math.ceil(this.rows / this.meta.per_page);
            }
        }
    }
}
</script>