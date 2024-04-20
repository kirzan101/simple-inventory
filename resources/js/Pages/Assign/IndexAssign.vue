<template>
    <div>
        <Navbar />
        <h1>&nbsp;</h1>
        <b-container fluid>
            <b-card bg-variant="light" text-variant="black" title="Add Inventories" border-variant="dark" class="mt-4">
                <template #header>
                    <h1>Assigns</h1>
                </template>
                <b-button
                    v-b-modal.assign-form-modal
                    class="my-3"
                    variant="success"
                    @click="add"
                >Add</b-button>

                <TableAssign 
                    :assigns="assigns"
                    :inventories="inventories"
                    :employees="employees"
                    :fields="fields"
                    :totalRows="total"
                    :perPage="per_page"
                    :filters="filters"
                    :current_page="current_page"
                    :assign="selectedAssign"
                    @toggle-search="loadData"
                    @selectChildAssign="selectAssign"
                />
            </b-card>
            
            <FormAssignModal 
                v-if="clickedAssign"
                :assign="selectedAssign"
                :inventories="inventories"
                :employees="employees"
                :formType="formType"
                @toggleEmpty="emptyFields"
                @toggleModal="closeModal"
            />
        </b-container>
        
    </div>
</template>

<script>
import Navbar from '../../Navbar.vue';

import {
    router
} from "@inertiajs/vue2";
import FormAssignModal from './FormAssignModal.vue';
import TableAssign from './TableAssign.vue';

export default {
    props: {
        assigns: Array,
        inventories: Array,
        employees: Array,
        per_page: Number,
        total: Number,
        last_page: Number,
        search: String,
        current_page: Number,
    },
    components: {
        Navbar,
        FormAssignModal,
        TableAssign,
    },
    data() {
        return{
            fields: ["name", "description", "employee_id", "inventory_id", "assigned_by", "action"],
            selectedAssign: {
                name: "",
                description: "",
                employee_id: "",
                inventory_id: "",
                assigned_by: "",
            },
            clickedAssign: false,
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
        selectAssign(assign){
            console.log(assign, "IndexAssign.vue-SelectAssign.method");
            this.selectedAssign = assign;
            this.clickedAssign = true;
            this.formType = "UPDATE";
        },
        add() {
            console.log("IndexAssign.vue-add.method", this.clickedAssign);
            this.clickedAssign = true;
            this.formType = "ADD"
        },
        emptyFields(){
            this.selectedAssign = Object.assign({}, "");
        },
        loadData(filter){
            router.reload({
                data: filter,
                only: [
                    "assigns",
                    "inventories",
                    "employees",
                    "per_page",
                    "total",
                    "last_page",
                    "search",
                    "current_page"
                ],
            });
        },
        closeModal(){
            this.clickedAssign = false;
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