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
            <b-pagination-nav :link-gen="linkGen" :number-of-pages="totalPages" use-router></b-pagination-nav>

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
        rows: Number,
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
            currentPage: this.meta.current_page,
        };
    },
    methods: {
        selectItem(item) {
            console.log(item, "item here", item['id']);
            this.selectedItem = item;
            this.clickedItem = true;
            this.formType = "UPDATE";
        },
        add() {
            console.log(this.meta);
            console.log(this.items);
            console.log("Item Length:", this.items.length);
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
    },
    computed: {
        totalPages() {
            console.log("meta:", this.meta.per_page);
            console.log("Pages: ", Math.ceil(this.rows / this.meta.per_page));
            return Math.ceil(this.rows / this.meta.per_page);
        }
    },
};
</script>
