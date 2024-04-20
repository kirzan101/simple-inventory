<template>
    <b-modal
        id="employee-form-modal"
        no-close-on-esc
        no-close-on-backdrop
        hide-header-close
        >

        <template #modal-title>
            <h1 v-if="isAdd">Add Employee</h1>
            <h1 v-else>Update Employee</h1>
        </template>

        <b-form @submit.prevent="submit" :inline="isAdd">

            <label v-if="formType == 'UPDATE'" for="inline-form-input-name">Name:</label>
            <label v-else class="sr-only" for="inline-form-input-name">Name</label>
            <b-form-input
                id="inline-form-input-name"
                class="mb-2 mr-sm-2"
                placeholder="Name"
                v-model="form.name"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-position">Position:</label>
            <label v-else class="sr-only" for="inline-form-input-position">Position</label>
            <b-form-input
                id="inline-form-input-position"
                class="mb-2 mr-sm-2"
                placeholder="Position"
                v-model="form.position"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-department">Department:</label>
            <label v-else class="sr-only" for="inline-form-input-department">Department</label>
            <b-form-input
                id="inline-form-input-department"
                class="mb-2 mr-sm-2"
                placeholder="Department"
                v-model="form.department"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-branch">Branch:</label>
            <label v-else class="sr-only" for="inline-form-input-branch">Branch</label>
            <b-form-input
                id="inline-form-input-branch"
                class="mb-2 mr-sm-2"
                placeholder="Branch"
                v-model="form.branch"
            ></b-form-input>
        </b-form>

        <template #modal-footer>
            <b-button variant="danger" @click="closed">Close</b-button>
            <b-button variant="primary" @click="submit">Save</b-button>
        </template>
        
    </b-modal>
</template>

<script>
import {router, useForm} from "@inertiajs/vue2"

export default {
    props: {
        employee: Object,
        formType: String,
    },
    data() {
        return {
            selected: null,
            form: useForm({
                name: "",
                position: "",
                department: "",
                branch: "",
            }),
            isAdd: false,
        }
    },
    watch: {
        employee: {
            handler(newEmployee) {
                this.form = this.employee;
            },
            immediate: true,
        }
    },
    methods: {
        submit() {
            console.log("submitted");

            if (this.formType === "ADD") {
                router.post("/employees", this.form);
                this.form.reset();
            } else if (this.formType === "UPDATE") {
                router.post(`/employees/${this.employee.id}`, {
                    _method: "PUT",
                    ...this.form,
                });
            }
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");
            this.$bvModal.hide("employee-form-modal");
        },
        closed() {
            console.log("FormEmployeeModal.vue-closed.method: ", this.employee)
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");
            this.$bvModal.hide("employee-form-modal");
        },
        empty() {
            this.from = useForm({
                name: "",
                position: "",
                department: "",
                branch: "",
            });
        },
    },
    created() {
        if(this.formType == "ADD") {
            this.isAdd = true;
        }
        console.log("Form Type: ", this.formType);
        console.log("Is Updated: ", this.isAdd);
        return this.isAdd;
    }
}
</script>