<template>
    <div class="container__header">
        <nav class="mb-2">
            <ol class="breadcrumb breadcrumb-sa-simple">
                <li class="breadcrumb-item"><a href="#">Главная</a></li>
                <li class="breadcrumb-item active">{{ title }}</li>
            </ol>
        </nav>
        <h1 class="h3 m-0">{{ title }}</h1>
    </div>
</template>

<script>

export default {
    data() {
        return {

        }
    },
    computed:{
        title(){
            return this.$attrs.data.title;
        }
    },
    mounted() {
    },
    methods: {
    }
}
</script>

<style>

</style>