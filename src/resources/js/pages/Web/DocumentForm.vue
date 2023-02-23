<template>
    <div class="container white">
        <div class="container__header">
            <div class="d-flex">
                <pageTitle :data="{title: document.id ? 'Редактирование документа' : 'Создание документа'}"/>
            </div>
        </div>
        <div class="container__body">
            <form action="#" @submit.prevent="submit()">
                <div class="mb-4">
                    <label class="form-label">Название страницы</label>
                    <input v-model.trim="document.title" type="text" name="url" class="form-control form-control-lg">
                </div>
                <div class="mb-4">
                    <label class="form-label">Содержание</label>
                    <input v-model.trim="document.content" type="text" name="url" class="form-control form-control-lg">
                </div>

                <button type="submit" class="btn btn-primary" @click.prevent="submit()">
                    <span v-if="document.id">Обновить</span>
                    <span v-else>Создать</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import PageTitle from "../../components/UI/PageTitle.vue";

export default {
    components: { PageTitle },
    props: ['page_id', 'document_id'],
    data() {
        return {
            document: {
                id: 0,
                page_id: '',
                title: '',
                content: '',
            },
        }
    },
    computed:{
        ...mapGetters('pages', ['PAGE', 'DOCUMENT']),
    },
    async mounted() {

        this.id = this.document_id ? parseInt(this.document_id) : null;

        let page = await this.GET(parseInt(this.page_id));

        this.document.page_id = page.id;

        if(this.document_id){
            this.document = page.documents.filter(item => item.id === this.id)[0];
        }

    },
    methods: {
        ...mapActions('pages', ['STOREDOCUMENT', 'GET', 'UPDATEDOCUMENT']),

        isError(value) {
            return this.error && this.error.errors[value] ? this.error.errors[value][0] : null;
        },

        async submit() {
            let resp = await this[this.id ? 'UPDATEDOCUMENT' : 'STOREDOCUMENT']({
                document: this.document,
            });

            if (resp && resp.status === "OK") {
                this.$router.push({ name: 'page_edit', params: {page_id: this.document.page_id}});
            }
        }
    }
}
</script>

<style>

</style>
