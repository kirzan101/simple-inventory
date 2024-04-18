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

            <label class="sr-only" for="inline-form-input-description">Description</label>
            <b-form-input
                id="inline-form-input-description"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Description"
                v-model="form.description"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-batch-number">Batch Number</label>
            <b-form-input
                id="inline-form-input-batch-number"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Batch Number"
                v-model="form.batch_number"
            ></b-form-input>

            <label class="sr-only" for="inline-form-input-serial-number">Serial Number</label>
            <b-form-input
                id="inline-form-input-serial-number"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Serial Number"
                v-model="form.serial_number"
            ></b-form-input>


            <label for="inline-form-input-item-id">Item ID</label>
            <select id="inline-form-input-item-id" class="form-select" aria-label="Default select example" v-model="form.item_id">
                <option v-for="(item, index) in items" :key="index" :value="item.id">{{ item.name }} - {{ item.id }}</option>
            </select>
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
        items: Array,
        formType: String,
    },
    data() {
        return {
            selected: null,
            form: useForm({
                name: "",
                description: "",
                batch_number: "",
                serial_number: "",
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
            console.log("Inventory:", this.inventory);
            console.log("Items:", this.items);
            this.$bvModal.hide("inventory-form-modal");
        }
    },
}
</script>