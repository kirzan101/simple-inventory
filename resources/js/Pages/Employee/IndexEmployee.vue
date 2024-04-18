<template>
    <div>
        <Navbar />
        <h1>Employees</h1>

        <b-button
            v-b-modal.employee-form-modal
            class="my-3"
            variant="success"
            @click="add"
            >Add</b-button>

        <b-pagination-nav :link-gen="linkGen" :number-of-pages="totalPages" use-router></b-pagination-nav>
        <b-container fluid>
            <b-table id="my-table" :fields="fields" striped hover :items="employees">
                <template #cell(action)="data">
                    <b-button
                    variant="primary"
                    >Update</b-button>
                </template>
            </b-table>
        </b-container>

        <FormEmployeeModal
            v-if="clickedItem"
            :employee="selectedEmployee"
        />

    </div>
</template>

<script>
import Navbar from '../../Navbar.vue';
import FormEmployeeModal from './FormEmployeeModal.vue';

export default {
    props: {
        employees: Array,
        rows: Number,
        meta: Object,
    },
    components: {
        Navbar,
        FormEmployeeModal,
    },
    data() {
        return {
            fields: ["name", "position", "department", "branch", "action"],
            selectedEmployee: {
                name: "",
                position: "",
                department: "",
                branch: "",
            },
            clickedItem: false,
            formType: "ADD",
            current_page: this.meta.current_page,
        }
    },
    methods: {
        selectEmployee(employee) {
            console.log(employee, "employee here");
            this.selectedEmployee = employee;
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