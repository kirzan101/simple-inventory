<template>
    <b-modal
        id="employee-form-modal"
        title="BootstrapVue"
        >
        <b-form @submit.prevent="submit" inline>
            <label class="sr-only" for="inline-form-input-name">Name</label>
            <b-form-input
                id="inline-form-input-name"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Name"
                v-model="form.name"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-position">Position</label>
            <b-form-input
                id="inline-form-input-position"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Position"
                v-model="form.position"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-department">Department</label>
            <b-form-input
                id="inline-form-input-department"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Department"
                v-model="form.department"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-branch">Branch</label>
            <b-form-input
                id="inline-form-input-branch"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Branch"
                v-model="form.branch"
            ></b-form-input>
        </b-form>
        
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
        }
    }
}
</script>