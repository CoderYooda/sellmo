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
                    <h1 class="h3 m-0">Товары</h1>
                </div>
                <div class="container__actions">
<!--                    <router-link :to="{ name: 'page_form'}" class="btn btn-primary header_button">Добавить страницу</router-link>-->
<!--                    <a href="#" class="btn btn-primary header_button">Добавить страницу</a>-->
                </div>
            </div>
        </div>
        <div class="container__body">
            <DataGridTable :entity="entity"/>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";


export default {

    data() {
        return {
            entity: 'products',
        }
    },
    computed: {
    },
    mounted() {
        // this.getCategoriesList();
    },
    methods:{

    }
}
</script>

<style>

</style>