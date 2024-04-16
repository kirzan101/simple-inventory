<template>
    <div>
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
        <!-- <h2>{{ sample }}</h2> -->
        <!-- <input type="text " v-model="sample" /> <br />
        <b-button v-b-modal.modal-1>Launch demo modal</b-button> -->

        <ShowHome :itemName="defaultName" @childInput="receiveInput" />
    </div>
</template>

<script>
import ShowHome from "./showHome.vue";

export default {
    props: {
        items: Array,
    },
    components: {
        ShowHome,
    },
    data() {
        return {
            sample: "tes",
            defaultName: "",
            childValue: "",
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
        }
    },
};
</script>
