<template>
<div>
    <Navbar />
    <h1>Items</h1>
    <b-container fluid>
        <b-button v-b-modal.item-form-modal class="my-3" variant="success" @click="add">Add</b-button>
        <!-- <b-pagination-nav :link-gen="linkGen" :number-of-pages="totalPages" use-router></b-pagination-nav>

            <p class="mt-3">Current Page: {{ currentPage }}</p>
            <p class="mt-3">Total Pages: {{ totalPages }}</p>
            <p class="mt-3">Total Rows: {{ rows }}</p>
            <b-table id="my-table" :fields="fields" striped hover :items="items">
                <template #cell(action)="data">
                    <b-button
                        @click="selectItem(data.item)"
                        v-b-modal.item-form-modal
                        variant="primary"
                        >Update</b-button
                    >
                </template>
            </b-table> -->

        <TableItem 
            :items="items" 
            :fields="fields" 
            :totalRows="total"
            :perPage="per_page"
            :filters="filters"
            :current_page="current_page"
            :item="selectedItem"
            @toggle-search="loadData"
            @selectChildItem="selectItem"
        />

        <FormItemModal v-if="clickedItem" :item="selectedItem" :formType="formType" @toggleEmpty="emptyFields" @toggleModal="closeModal"/>
    </b-container>
</div>
</template>

<script>
import Navbar from "../../Navbar.vue";
import FormItemModal from "./FormItemModal.vue";
import TableItem from "./TableItem.vue";
import {
    router
} from "@inertiajs/vue2";

export default {
    props: {
        items: Array,
        per_page: Number,
        total: Number,
        last_page: Number,
        search: String,
        current_page: Number,
    },
    components: {
        Navbar,
        FormItemModal,
        TableItem,
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
            filters: {
                per_page: "",
                search: "",
                current_page: "",
                page: "",
            },
        };
    },
    methods: {
        selectItem(item) {
            this.selectedItem = item;
            this.clickedItem = true;
            this.formType = "UPDATE";
        },
        add() {
            console.log("Clicked add");
            this.clickedItem = true;
            this.formType = "ADD";
        },
        emptyFields() {
            console.log('here1!!')
            this.selectedItem = Object.assign({}, "");
        },
        linkGen(pageNum) {
            return pageNum === 1 ? '?' : `?page=${pageNum}`
        },
        loadData(filter) {
            router.reload({
                data: filter,
                only: [
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
           this.clickedItem = false; 
        }
    },
    created() {
        this.filters.search = this.search,
        this.filters.per_page = this.per_page,
        this.filters.current_page = this.current_page,
        this.filters.page = this.current_page
    }

};
</script>
