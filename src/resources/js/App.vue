<template lang="">
    <div v-if="isLoading">123</div>
    <component :is="layout"></component>
</template>

<script>
import Auth from './layouts/Auth.vue';
import Main from './layouts/Main.vue';
import {mapGetters} from "vuex";

export default {
    name: 'app',
    components: {
        Auth,
        Main,
    },
    mounted() {

    },
    computed: {

        ...mapGetters(['LOADING']),

        isLoading(){
          // return this.LOADING();
        },

        layout() {
            return this.$route.meta.layout || 'Auth';
        }
    }
}
</script>
