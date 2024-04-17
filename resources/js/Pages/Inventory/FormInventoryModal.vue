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
                id="inline-form-input-description"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Description"
                v-model="form.description"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-name">BatchNumber</label>
            <b-form-input
                id="inline-form-input-batch-number"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Batch Number"
                v-model="form.batch_number"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-name">ItemID</label>
            <b-form-input
                id="inline-form-input-item-id"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Item ID"
                v-model="form.item_id"
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
        inventory: Object,
        formType: String,
    },
    data() {
        return {
            form: useForm({
                name: "",
                description: "",
                batch_number: "",
                item_id: "",
            }),
        };
    },
    watch: {
        inventory: {
            handler(newItem) {
                // Update form data when item prop changes
                this.form = this.inventory;
            },
            immediate: true, // Update immediately when component is created
        },
    },
    methods: {
        submit() {
            console.log("submitted");

            if (this.formType === "ADD") {
                console.log("form", this.form);
                router.post("/inventories", this.form);
                this.form.reset();
            } else if (this.formType === "UPDATE") {
                router.post(`/inventories/${this.inventory.id}`, {
                    _method: "PUT",
                    ...this.form,
                });
            }
            this.$emit("toggleEmpty");
            this.$bvModal.hide("inventory-form-modal");
        },
        closed() {
            console.log(this.inventory);
            this.$bvModal.hide("inventory-form-modal");
        }
    },
}
</script>