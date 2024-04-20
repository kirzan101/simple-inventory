<template>
    <div>
        <Navbar />
        <h1 class="">&nbsp;</h1>

        <b-container fluid>
            <b-card bg-variant="light" text-variant="black" title="Add Inventories" class="mt-4" border-variant="dark"> 
                <template #header>
                    <h1>Inventories Page</h1>
                </template>
                <b-button 
                    v-b-modal.inventory-form-modal
                    class="my-3"
                    variant="success"
                    @click="add"
                    >Add</b-button>
            
            <!-- <b-pagination-nav :link-gen="linkGen" :number-of-pages="totalPages" use-router></b-pagination-nav>

            <p class="mt-3">Current Page: {{ currentPage }}</p>

            <b-table id="my-table" :fields="fields" striped hover :items="inventories">
                <template #cell(action)="data">
                    <b-button
                        @click="selectInventory(data.item)"
                        v-b-modal.inventory-form-modal
                        variant="primary"
                        >Update</b-button>
                </template>
            </b-table>       -->

            <TableInventory
                :inventories="inventories"
                :items="items"
                :fields="fields"
                :totalRows="total"
                :perPage="per_page"
                :filters="filters"
                :current_page="current_page"
                :inventory="selectedInventory"
                @toggle-search="loadData"
                @selectChildInventory = "selectInventory"
            />
            </b-card>

            <FormInventoryModal
                v-if="clickedInventory"
                :inventory="selectedInventory"
                :items="items"
                :formType="formType"
                @toggleEmpty="emptyFields" 
                @toggleModal="closeModal"
            />
        </b-container>
    </div>
</template>

<script>
import Navbar from '../../Navbar.vue';
import FormInventoryModal from './FormInventoryModal.vue';
import TableInventory from './TableInventory.vue';
import {
    router
} from "@inertiajs/vue2";

export default {
    props: {
        inventories: Array,
        items: Array,
        per_page: Number,
        total: Number,
        last_page: Number,
        search: String,
        current_page: Number,
    },
    components: {
        Navbar,
        FormInventoryModal,
        TableInventory,
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
            clickedInventory: false,
            formType: "ADD",
            filters: {
                per_page: "",
                search: "",
                current_page: "",
                page: "",
            },
        };
    },
    methods: {
        selectInventory(inventory) {
            console.log(inventory, "item here");
            this.selectedInventory = inventory;
            this.clickedInventory = true;
            this.formType = "UPDATE";
        },
        add() {
            console.log("add");
            console.log(this.clickedInventory);
            this.clickedInventory = true;
            this.formType = "ADD";
        },
        emptyFields(){
            this.selectedInventory = Object.assign({}, "");
        },
        loadData(filter){
            router.reload({
                data: filter,
                only: [
                    "inventories",
                    "items",
                    "per_page",
                    "total",
                    "last_page",
                    "search",
                    "current_page"
                ],
            });
        },
        closeModal(){
            this.clickedInventory = false;
        }
    },
    created(){
        this.filters.search = this.search,
        this.filters.per_page = this.per_page,
        this.filters.current_page = this.current_page,
        this.filters.page = this.current_page
    }
};
</script>