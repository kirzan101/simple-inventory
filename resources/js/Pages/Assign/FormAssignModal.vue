<template>
    <b-modal
        id="assign-form-modal"
        no-close-on-esc
        no-close-on-backdrop
        hide-header-close
    >
        <template #modal-title>
            <h1 v-if="isAdd">Add Item</h1>
            <h1 v-else>Update Item</h1>
        </template>

        <!-- <b-form @submit.prevent="submit" :inline="isAdd"> -->
        <b-form @submit.prevent="submit">
            <label v-if="formType == 'UPDATE'" for="inline-form-input-name">Name:</label>
            <label v-else class="sr-only" for="inline-form-input-name">Name</label>
            <b-form-input 
                id="inline-form-input-name"
                class="mb-2 mr-sm-2"
                placeholder="Name" 
                v-model="form.name"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-description">Description:</label>
            <label v-else class="sr-only" for="inline-form-input-description">Description</label>
            <b-form-input 
                id="inline-form-input-description"
                class="mb-2"
                placeholder="Description" 
                v-model="form.description"
            ></b-form-input>

            <label for="inline-form-input-employee-id">Employee:</label>
            <br>
            <select id="inline-form-input-employee-id" class="form-select mb-2" aria-label="Input Employee ID" v-model="form.employee_id">
                <option selected>Choose...</option>
                <option v-for="(employee, index) in employees" :key="index" :value="employee.id">{{ employee.name }} - {{ employee.id }}</option>
            </select>
            <br>

            <label for="inline-form-input-inventory-id">Inventory:</label>
            <br>
            <select id="inline-form-input-inventory-id" class="form-select mb-2" aria-label="Input Inventory ID" v-model="form.inventory_id">
                <option v-for="(inventory, index) in inventories" :key="index" :value="inventory.id">{{ inventory.name }} - {{ inventory.id }}</option>
            </select>
            <br>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-assigned-by">Assigned By:</label>
            <label v-else class="sr-only" for="inline-form-input-assigned-by">Assigned By</label>
            <b-form-input 
                id="inline-form-input-assigned-by"
                class="mb-2"
                placeholder="Assigned By" 
                v-model="form.assigned_by"
            ></b-form-input>
        </b-form>

        <template #modal-footer>
            <b-button variant="danger" @click="closed">Close</b-button>
            <b-button variant="primary" @click="submit">Save</b-button>
        </template>
    </b-modal>
</template>

<script>
import { router, useForm } from "@inertiajs/vue2";

export default {
    props: {
        assign: Object,
        inventories: Array,
        employees: Array,
        formType: String,
    },
    data() {
        return {
            form: useForm({
                name: "",
                description: "",
                employee_id: "",
                inventory_id: "",
                assigned_by: "",
            }),
            isAdd: false,
        };
    },
    watch: {
        assign: {
            handler(newAssign) {
                this.form = this.assign;
            },
            immediate: true,
        },
    },
    methods: {
        submit(){
            console.log("FormAssignModal.vue-submit.method");

            if (this.formType === "ADD") {
                router.post("/assigns", this.form);
                this.form.reset();
            } else if (this.formType === "UPDATE") {
                router.post(`/assigns/${this.assign.id}`,{
                    _method: "PUT",
                    ...this.form,
                });
            }
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");

            this.$bvModal.hide("assign-form-modal");
        },
        closed() {
            console.log("FormAssignModal.vue-closed.method", this.assign);
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");
            this.$bvModal.hide("assign-form-modal");
        },
        empty() {
            this.form = useForm({
                name: "",
                description: "",
                employee_id: "",
                inventory_id: "",
                assigned_by: "",
            });
        }
    },
    created() {
        if(this.formType == "ADD") {
            this.isAdd = true;
        }
        console.log("FormAssignModal.vue-created.hook-Form Type: ", this.formtype);
        console.log("FormAssignModal.vue-created.hook-Is add: ", this.isAdd);
        return this.isAdd;
    },
}
</script>