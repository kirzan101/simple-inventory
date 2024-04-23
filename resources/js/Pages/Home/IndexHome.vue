<template>
    <div>
        <Navbar />
        <h1>Home | Child input here: {{ childValue }}</h1>
        <h1 v-if="false">v-if</h1>
        <h1 v-else>v-else</h1>
        <ul>
            <li
                v-for="(item, index) in items"
                :key="index"
                v-b-modal.modal-1
                @click="passItem(item.name)"
            >
                {{ item.name }}
            </li>
        </ul>
        <b-button @click="makeToast(false, 'success')">Show Toast</b-button>
        <b-button @click="makeToast(true)">Show Toast (appended)</b-button>
        <!-- <h2>{{ sample }}</h2> -->
        <!-- <input type="text " v-model="sample" /> <br />
        <b-button v-b-modal.modal-1>Launch demo modal</b-button> -->

        <ShowHome :itemName="defaultName" @childInput="receiveInput" />
    </div>
</template>

<script>
import Navbar from "../../Navbar.vue";
import ShowHome from "./showHome.vue";

export default {
    props: {
        items: Array,
    },
    components: {
        Navbar,
        ShowHome,
    },
    data() {
        return {
            sample: "tes",
            defaultName: "",
            childValue: "",
            toastCount: 0
        };
    },
    methods: {
        passItem(item) {
            console.log("here");
            this.defaultName = item;
        },
        receiveInput(data, secondData) {
            this.childValue = data;
            console.log('secondData', secondData)
        },
        makeToast(append = false, variant = null) {
            this.toastCount++
            this.$bvToast.toast(`This is toast number ${this.toastCount}`, {
                title: 'BootstrapVue Toast',
                autoHideDelay: 5000,
                appendToast: append,
                solid: true,
                variant: variant,
                toaster: 'b-toaster-bottom-left',
            })
        },
    },
};
</script>
