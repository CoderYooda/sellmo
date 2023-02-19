<template>
    <div class="container white">
        <div class="container__header">
            <div class="d-flex">
                <PageTitle :data="{title: page.id ? 'Редактирование страницы' : 'Создание новой страницы'}"/>

            </div>
        </div>
        <div class="container__body">
            <form action="#" @submit.prevent="submit()">
                <div class="mb-4">
                    <label class="form-label">Название страницы</label>
                    <input v-model.trim="page.title" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">URL адрес</label>
                    <input v-model.trim="page.slug" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">СЕО заголовок</label>
                    <input v-model.trim="page.seo_title" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">СЕО описание</label>
                    <input v-model.trim="page.seo_description" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">H1 заголовок</label>
                    <input v-model.trim="page.header" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">Статус публикации</label>
                    <input v-model.trim="page.isPublished" type="text" name="url" class="form-control form-control-lg">
                </div>
                <button type="submit" class="btn btn-primary" @click.prevent="submit()">
                    <span v-if="page.id">Обновить</span>
                    <span v-else>Создать</span>
                </button>
            </form>
        </div>
    </div>
    <div class="container full pl-0">
        <div class="container__actions">
            <router-link :to="{ name: 'document_edit', params: { page_id: page.id }}" class="btn btn-primary header_button">Добавить документ</router-link>
        </div>
        <div class="card p-md-5">

            <div class="sa-grid">
                <div class="sa-grid__body">
                    <div  v-for="document in page.documents" :key="document.id" class="sa-grid__item">
                        <a href="#" class="sa-folder">
                            <div class="sa-folder__image">
                                <div class="doc-icon"></div>
                            </div>
                            <div class="sa-folder__info">

                                <div class="sa-folder__name">{{ document.title }}</div>
                                <div class="sa-folder__meta"><router-link :to="{ name: 'document_edit', params: { document_id: document.id, page_id: page.id }}">Редактировать (ID{{ document.id }})</router-link></div>
                            </div>
                        </a>
                    </div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                    <div class="sa-grid__filler" role="presentation"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../components/UI/PageTitle.vue";
export default {
    components: { PageTitle },
    props: ['page_id'],
    data() {
        return {
            page: {
                id: 0,
                title: '',
                slug: '',
                seo_title: '',
                seo_description: '',
                header: '',
                isPublished: '',
            },
        }
    },
    computed:{
        ...mapGetters('pages', ['PAGE']),
    },
    async mounted() {
        this.id = this.page_id ? parseInt(this.page_id) : null;

        if(this.id){
            this.page = await this.GET(this.id);
        }
    },
    methods: {
        ...mapActions('pages', ['STORE', 'GET', 'UPDATE']),

        isError(value) {
            return this.error && this.error.errors[value] ? this.error.errors[value][0] : null;
        },

        async submit() {

            let resp = await this[this.id ? 'UPDATE' : 'STORE']({
                page: this.page,
            });

            if (resp && resp.status === "OK") {
                this.$router.push({ name: 'web'});
            }
        }
    }
}
</script>

<style>

</style>
