<template>
    <div>
        <div class="form_row" v-for="(row, i) in rows" key="i">
            <div v-for="field in row.fields">
                <component :is="field.type" :data="field" v-model="reqData[field.name]"></component>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

import Input from "./Fields/Input.vue";

export default {
    name: "DataForm",
    components: {Input},
    data() {
        return {
            reqData: {},
        }
    },
    mounted() {
        this.getFormData();
    },
    methods:{
        ...mapActions('form', ['FORMDATA']),

        async getFormData() {
            let resp = await this.FORMDATA({
                tag: this.$attrs.tag,
            });

        },
    },
    computed: {
        ...mapGetters('form', ['DATA']),
        data() {
            return this.DATA;
        },
        rows(){
            return this.data.rows;
        },
        fields(){
            // for (let row in this.rows){
            //     for (let field in row.fields){
            //         console.log(field);
            //     }
            // }
        }

    }
}
</script>

<style scoped>

</style>
