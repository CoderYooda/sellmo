<template>
    <div class="container full">
        <div class="container__header">
            <div class="d-flex">
                <div class="container__header">
                    <nav class="mb-2">
                        <ol class="breadcrumb breadcrumb-sa-simple">
                            <li class="breadcrumb-item"><a href="#">Главная</a></li>
                            <li class="breadcrumb-item"><a href="#">Категории 1</a></li>
                            <li class="breadcrumb-item"><a href="#">Категории 2</a></li>
                            <li class="breadcrumb-item active">Категории 3</li>
                        </ol>
                    </nav>
                    <h1 class="h3 m-0">Список товаров</h1>
                </div>
                <div class="container__actions">
                    <a href="#" class="btn btn-secondary header_button">Добавить товар</a>
                    <a href="#" class="btn btn-primary header_button">Добавить товар</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    // components: {Company},
  mounted() {

  },
}
</script>

<style>

</style>