<template>
    <b-container fluid>
        <!-- User Interface Controls -->
        <b-row>
            <b-col lg="6" class="my-1">
                <b-form-group label="Sort" label-for="sort-by-select" label-cols-sm="3" label-align-sm="right" label-size="sm" class="mb-0" v-slot="{ ariaDescribedby }">
                    <b-input-group size="sm">
                        <b-form-select id="sort-by-select" v-model="sortBy" :options="sortOptions" :aria-describedby="ariaDescribedby" class="w-75">
                            <template #first>
                                <option value="">-- none --</option>
                            </template>
                        </b-form-select>

                        <b-form-select v-model="sortDesc" :disabled="!sortBy" :aria-describedby="ariaDescribedby" size="sm" class="w-25">
                            <option :value="false">Asc</option>
                            <option :value="true">Desc</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col lg="6" class="my-1">
                <b-form-group label="Filter" label-for="search-input" label-cols-sm="3" label-align-sm="right" label-size="sm" class="mb-0">
                    <b-input-group size="sm">
                        <b-form-input id="search-input" v-model="filters.search" type="search" placeholder="Type to Search"></b-form-input>

                        <b-input-group-append>
                            <b-button :disabled="!filters.search" @click="filters.search=''">Clear</b-button>
                        </b-input-group-append>                        
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col sm="5" md="6" class="my-1">
                <b-form-group label="Per page" label-for="per-page-select" label-cols-sm="6" label-cols-md="4" label-cols-lg="3" label-align-sm="right" label-size="sm" class="mb-0">
                    <b-form-select id="per-page-select" v-model="filters.per_page" :options="pageOptions" size="sm"></b-form-select>
                </b-form-group>
            </b-col>
            <b-col sm="7" md="6" class="my-1">
                <b-pagination v-model="filters.page" :total-rows="totalRows" :per-page="filters.per_page" align="fill" size="sm" class="my-0"></b-pagination>
            </b-col>
        </b-row>

        <!-- Main table element -->
        <b-table :items="assigns" :fields="fields" :current-page="filters.current_page" :per-page="filters.per_page" :search="search" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection" stacked="md" show-empty small>
            <template #cell(action)="data">
                <b-button @click="selectChild(data.item)" v-b-modal.assign-form-modal variant="primary">Update</b-button>
            </template>
        </b-table>
    </b-container>
</template>

<script>


export default {
    props: {
        assigns: Array,
        inventories: Array,
        employees: Array,
        fields: Array,
        totalRows: Number,
        perPage: Number,
        filters: Object
    },
    component: {

    },
    data() {
        return {
            pageOptions: [5, 10, 15, {
                value: 100,
                text: "Show a lot"
            }],
            sortBy: "",
            sortDesc: false,
            sortDirection: "asc",
            search: "",
            clickedItem: false,
        }
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter((f) => f.sortable)
                .map((f) => {
                    return {
                        text: f.label,
                        value: f.key
                    };
                });
        },
    },
    methods: {
        selectChild(assign) {
            console.log("TableAssign.vue-selectChild.method: ", assign);
            this.$emit("selectChildAssign", assign);
        },
    },
    watch: {
        "filters.search"() {
            this.$emit('toggle-search', this.filters)
        },
        "filters.per_page"() {
            this.$emit('toggle-search', this.filters)
        },
        "filters.current_page"() {
            this.$emit('toggle-search', this.filters)
        },
        "filters.page"() {
            this.$emit('toggle-search', this.filters)
        },
        
    },
}

</script>