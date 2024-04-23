<template>
<div>
    <Navbar />
    <h1>&nbsp;</h1>
    <b-container fluid>
        <b-card bg-variant="light" text-variant="black" title="Add Items" class="mt-4" border-variant="dark"> 
            <template #header>
                    <h1>Items Page</h1>
            </template>
            <b-button v-b-modal.item-form-modal variant="success" @click="add" class="my-3">Add</b-button>
            <TableItem 
                :items="items" 
                :fields="fields" 
                :totalRows="total"
                :perPage="per_page"
                :filters="filters"
                :currentPage="current_page"
                :item="selectedItem"
                @toggle-search="loadData"
                @selectChildItem="selectItem"
            />
        </b-card>

        <FormItemModal 
            v-if="clickedItem" 
            :item="selectedItem" 
            :formType="formType" 
            :errors="errors"
            @toggleEmpty="emptyFields" 
            @toggleModal="closeModal"
            @toggleToast="makeToast"
        />
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
        errors: Object,
    },
    components: {
        Navbar,
        FormItemModal,
        TableItem,
    },
    data() {
        return {
            fields: [
                {key: 'name', label: 'Name', sortable: true, sortDirection: 'desc'},
                {key: 'description', label: 'Description', sortable: true, sortDirection: 'desc'},
                {key: 'model', label: 'Model', sortable: true, sortDirection: 'desc'},
                {key: 'brand', label: 'Brand', sortable: true, sortDirection: 'desc'},
                {key: 'action', label: 'Action'},
            ],
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
            console.log("(IndexItem.vue-add.method) errors: ", this.errors);
            console.log("(IndexItem.vue-add.method) errorFields:", this.errorFields);
            this.clickedItem = true;
            this.formType = "ADD";
        },
        emptyFields() {
            console.log('(IndexItem.vue-emptyFields.method) ');
            this.selectedItem = Object.assign({}, "");
            Object.keys(this.errors).forEach((key) => {
                this.errors[key] = "";
            });
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
                    "current_page",
                ],
            });
        },
        closeModal() {
            this.clickedItem = false; 
        },
        makeToast(variant = null, title = null, message = null) {
            this.$bvToast.toast( message , {
                title: title,
                autoHideDelay: 3000,
                appendToast: false,
                solid: true,
                variant: variant,
                toaster: 'b-toaster-bottom-left',
            })
        },
    },
    created() {
        this.filters.search = this.search,
        this.filters.per_page = this.per_page,
        this.filters.page = this.current_page
    },

};
</script>
