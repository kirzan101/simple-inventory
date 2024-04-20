<template>
    <div>
        <Navbar />
        <h1>&nbsp;</h1>

        <b-container fluid>
            <b-card bg-variant="light" text-variant="black" title="Add Employees" class="mt-4" border-variant="dark">
                <template #header>
                    <h1>Employees Page</h1>
                </template>
            
                <b-button
                    v-b-modal.employee-form-modal
                    class="my-3"
                    variant="success"
                    @click="add"
                    >Add</b-button
                >

                <!-- <b-pagination-nav :link-gen="linkGen" :number-of-pages="totalPages" use-router></b-pagination-nav>
                <b-container fluid>
                    <b-table id="my-table" :fields="fields" striped hover :items="employees">
                        <template #cell(action)="data">
                            <b-button
                            variant="primary"
                            >Update</b-button>
                        </template>
                    </b-table>
                </b-container> -->
                <TableEmployee
                    :employees="employees"
                    :fields="fields"
                    :totalRows="total"
                    :perPage="per_page"
                    :filters="filters"
                    :current_page="current_page"
                    @toggle-search="loadData"
                    @selectChildEmployee="selectEmployee"
                />
            </b-card>
            <FormEmployeeModal 
                v-if="clickedEmployee" 
                :employee="selectedEmployee" 
                :formType="formType"
                @toggleEmpty="emptyFields"
                @toggleModal="closeModal"
            />
        </b-container>
        
    </div>
</template>

<script>
import Navbar from "../../Navbar.vue";
import FormEmployeeModal from "./FormEmployeeModal.vue";
import TableEmployee from "./TableEmployee.vue";
import { router } from "@inertiajs/vue2";

export default {
    props: {
        employees: Array,
        per_page: Number,
        total: Number,
        last_page: Number,
        search: String,
        current_page: Number,
    },
    components: {
        Navbar,
        FormEmployeeModal,
        TableEmployee,
    },
    data() {
        return {
            // fields: [
            //     { key: "name", label: "Full Name" },
            //     { key: "position", label: "Position" },
            //     { key: "department", label: "Department" },
            //     { key: "branch", label: "Branch" },
            //     { key: "", label: "Action" },
            // ],
            fields: ["name", "position", "department", "branch", "action"],
            selectedEmployee: {
                name: "",
                position: "",
                department: "",
                branch: "",
            },
            clickedEmployee: false,
            formType: "ADD",
            filters: {
                per_page: "",
                search: "",
                current_page: "",
                page: ""
            },
        };
    },
    methods: {
        selectEmployee(employee) {
            console.log(employee, "employee here");
            this.selectedEmployee = employee;
            this.clickedEmployee = true;
            this.formType = "UPDATE";
        },
        add() {
            console.log("IndexEmployee.vue-add.method", this.clickedEmployee);
            this.clickedEmployee = true;
            this.formType = "ADD";
        },
        emptyFields() {
            this.selectedEmployee = Object.assign({}, "");
        },
        loadData(filter) {
            router.reload({
                data: filter,
                only: [
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
            this.clickedEmployee = false;
        }
    },
    created() {
        this.filters.search = this.search,
        this.filters.per_page = this.per_page
        this.filters.current_page = this.current_page
        this.filters.page = this.current_page
    }
};
</script>
