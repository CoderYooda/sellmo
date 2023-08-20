<template>
    <div class="container white">
        <div class="container__header">
            <div class="d-flex">
                <pageTitle :data="'Создание товара'"/>
            </div>
        </div>
        <div class="container__body">
            <form action="#" @submit.prevent="submit()">
                <div class="mb-4">
                    <label class="form-label">Название страницы1</label>
                    <input v-model.trim="product.title" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">Содержание</label>
                    <input v-model.trim="product.content" type="text" name="url" class="form-control form-control-lg">
                </div>

                <button type="submit" class="btn btn-primary" @click.prevent="submit()">
                    <span v-if="product.id">Обновить</span>
                    <span v-else>Создать</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../../components/UI/PageTitle.vue";

export default {
    name: 'Login',
    components: {PageTitle},

    data() {
        return {
            product: {
                id: 0,
                page_id: '',
                title: '',
                content: '',
            },
        }
    },
    computed: {
    },

    methods: {
        ...mapActions('auth', ['LOGIN']),

        isError(value) {
            return this.error && this.error.errors[value] ? this.error.errors[value][0] : null;
        },

        async submit() {
            let resp = await this.LOGIN({
                email: this.email,
                password: this.password
            });

            if (resp && resp.status === 'ok') {
                this.$router.push({ name: 'main'});
            }
        }
    }
}
</script>

<style>

</style>
