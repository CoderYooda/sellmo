<template>
    <div class="card auth_card">
        <div class="card-body p-sm-5 m-sm-3 flex-grow-0">
            <h1 class="mb-0 fs-3">Авторизация</h1>
            <div class="mb-4">
                <label class="form-label">Email</label>
                <input v-model.trim="email" type="email" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
                <label class="form-label">Пароль</label>
                <input v-model.trim="password" type="password" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
                <label class="form-label">Подтверждение</label>
                <input v-model.trim="password_confirmation" type="password" class="form-control form-control-lg">
            </div>
            <div><a href="#" @click="submit()" class="btn btn-primary btn-lg w-100">Войти</a></div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'Login',

    data() {
        return {
            email: null,
            password: null,
            password_confirmation: null,
        }
    },

    computed: {
        ...mapGetters('auth', ['ERRORS', 'HAS_ERRORS']),

        error() {
            return this.ERRORS.error;
        },

        hasErrors() {
            return this.HAS_ERRORS;
        }
    },

    methods: {
        ...mapActions('auth', ['REGISTER']),

        async submit() {
            let resp = await this.REGISTER({
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            });
            console.log(resp)
            if (resp && resp.status === "OK") {

                this.$router.push({ name: 'main'});
            }
        }
    }
}
</script>

<style>

</style>