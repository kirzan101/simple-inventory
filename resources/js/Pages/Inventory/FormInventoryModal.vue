 <template>
    <b-modal
        id="inventory-form-modal"
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

            <label v-if="formType == 'UPDATE'" for="inline-form-input-batch-number">Batch Number:</label>
            <label v-else class="sr-only" for="inline-form-input-batch-number">Batch Number</label>
            <b-form-input
                id="inline-form-input-batch-number"
                class="mb-2 mr-sm-2"
                placeholder="Batch Number"
                v-model="form.batch_number"
            ></b-form-input>

            <label v-if="formType == 'UPDATE'" for="inline-form-input-serial-number">Serial Number:</label>
            <label v-else class="sr-only" for="inline-form-input-serial-number">Serial Number</label>
            <b-form-input
                id="inline-form-input-serial-number"
                class="mb-2 mr-sm-2"
                placeholder="Serial Number"
                v-model="form.serial_number"
            ></b-form-input>


            <label for="inline-form-input-item-id">Item ID:</label>
            <br>
            <select 
                id="inline-form-input-item-id" 
                class="form-select" 
                aria-label="Default select example" 
                v-model="form.item_id"
                
            >
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
            form: useForm({
                name: "",
                description: "",
                batch_number: "",
                serial_number: "",
                item_id: "",
            }),
            isAdd: false,
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
                router.post("/inventories", this.form);
                this.form.reset();
            } else if (this.formType === "UPDATE") {
                router.post(`/inventories/${this.inventory.id}`, {
                    _method: "PUT",
                    ...this.form,
                });
            }
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");

            this.$bvModal.hide("inventory-form-modal");
        },
        closed() {
            console.log("Modal Inventory:", this.inventory);
            this.$emit("toggleModal");
            this.$emit("toggleEmpty");
            this.$bvModal.hide("inventory-form-modal");
        },

        empty() {
            this.form = useForm({
                name: "",
                description: "",
                batch_number: "",
                serial_number: "",
                item_id: "",
            });
        }
    },
    created() {
        if(this.formType == "ADD"){
            this.isAdd = true;
        }
        console.log("Form Type: ", this.formType);
        console.log("Is Updated: ", this.isAdd);
        return this.isAdd;
    },
}
</script>