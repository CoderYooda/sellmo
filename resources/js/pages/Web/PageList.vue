<template>
    <div class="container full">
        <div class="container__header">
            <div class="d-flex">
                <div class="container__header">
                    <nav class="mb-2">
                        <ol class="breadcrumb breadcrumb-sa-simple">
                            <li class="breadcrumb-item"><a href="#">Главная</a></li>
                            <li class="breadcrumb-item active">Статичные страницы</li>
                        </ol>
                    </nav>
                    <h1 class="h3 m-0">Статичные страницы</h1>
                </div>
                <div class="container__actions">
                    <router-link :to="{ name: 'page_form'}" class="btn btn-primary header_button">Добавить страницу</router-link>
<!--                    <a href="#" class="btn btn-primary header_button">Добавить страницу</a>-->
                </div>
            </div>
        </div>
        <div class="container__body">
            <div class="card">
                <div class="listed_container">
                    <div v-for="page in pages" class="listed_container__item">
                        {{ page.title }}
                        <router-link :to="{ name: 'page_edit', params: { page_id: page.id }}" class="btn btn-primary header_button ml-auto">Редактировать</router-link>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters('pages', ['PAGES']),

        pages() {
            return this.PAGES;
        },

        pages_loaded(){
            return this.pages !== null;
        }
    },
    mounted() {
        this.getPagesList();
    },
    methods:{
        ...mapActions('pages', ['LIST']),

        async getPagesList() {
            let resp = await this.LIST();
        },
    }
}
</script>

<style>

</style>