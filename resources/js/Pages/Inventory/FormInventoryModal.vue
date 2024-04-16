<template>
    <b-modal
        id="inventory-form-modal"
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

            <label class="sr-only" for="inline-form-input-name">Description</label>
            <b-form-input
                id="inline-form-input-name"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Description"
                v-model="form.description"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-name">Model</label>
            <b-form-input
                id="inline-form-input-name"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Model"
                v-model="form.model"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-name">Brand</label>
            <b-form-input
                id="inline-form-input-name"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Brand"
                v-model="form.brand"
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
        item: Object,
        formType: String,
    },
    data() {
        return {
            form: useForm({
                name: "",
                description: "",
                model: "",
                brand: "",
            }),
        };
    },
    }
</script>