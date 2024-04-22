<template>
    <b-modal
        id="item-form-modal"
        no-close-on-esc
        no-close-on-backdrop
        hide-header-close
    >   
        <template #modal-title>
            <h1 v-if="isAdd">Add Item</h1>
            <h1 v-else>Update Item</h1>
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

            <label v-if="formType == 'UPDATE'" for="inline-form-input-description">Description:</label>
            <label v-else class="sr-only" for="inline-form-input-description">Description</label>
            <b-form-input
                id="inline-form-input-description"
                class="mb-2 mr-sm-2"
                placeholder="Description"
                v-model="form.description"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-model">Model:</label>
            <label v-else class="sr-only" for="inline-form-input-model">Model</label>
            <b-form-input
                id="inline-form-input-model"
                class="mb-2 mr-sm-2"
                placeholder="Model"
                v-model="form.model"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-brand">Brand:</label>
            <label v-else class="sr-only" for="inline-form-input-brand">Brand</label>
            <b-form-input
                id="inline-form-input-brand"
                class="mb-2 mr-sm-2"
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
            isAdd: false,
        };
    },
    watch: {
        item: {
            handler(newItem) {
                // Update form data when item prop changes
                this.form = this.item;
            },
            immediate: true, // Update immediately when component is created
        },
    },
    methods: {
        submit() {
            console.log("FormItemModal.vue-submit.method Errors ", this.errors);
            if (this.formType === "ADD") {

                router.post("/items", this.form);

            } else if (this.formType === "UPDATE") {
                router.post(`/items/${this.item.id}`, {
                    _method: "PUT",
                    ...this.form,
                });
            }
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");

            this.$bvModal.hide("item-form-modal");
        },
        closed() {
            console.log("Modal Item:", this.item);
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");
            this.$bvModal.hide("item-form-modal");
        },
        
        empty() {
            this.form = useForm({
                name: "",
                description: "",
                model: "",
                brand: "",
            });
        },
    },
    computed: {
        // checkUpdate(formType) {
        //     // Create an options list from our fields
            
        // },
    },
    created() {
        // this.form = this.item;
        if(this.formType == "ADD"){
            this.isAdd = true;
        }
        console.log("Form Type: ", this.formType);
        console.log("Is Updated: ", this.isAdd);
        return this.isAdd;
    },

};
</script>
