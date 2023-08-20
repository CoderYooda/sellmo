<template>
    <div class="card auth_card">
        <div class="card-body p-sm-5 m-sm-3 flex-grow-0">
            <h1 class="mb-0 fs-3">Регистрация</h1>
            <div class="mb-4">
                <label class="form-label">Email</label>
                <input v-model.trim="email" type="email" class="form-control form-control-lg" :class="[ HAS_ERROR('email') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('email')">{{ error.errors['email'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Пароль</label>
                <input v-model.trim="password" type="password" class="form-control form-control-lg" :class="[ HAS_ERROR('password') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('password')">{{ error.errors['password'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Подтверждение</label>
                <input v-model.trim="password_confirmation" type="password" class="form-control form-control-lg" :class="[ HAS_ERROR('password_confirmation') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('password_confirmation')">{{ error.errors['password_confirmation'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Название компании</label>
                <input v-model.trim="company_name" type="text" class="form-control form-control-lg" :class="[ HAS_ERROR('company_name') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('company_name')">{{ error.errors['company_name'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Имя</label>
                <input v-model.trim="first_name" type="text" class="form-control form-control-lg" :class="[ HAS_ERROR('first_name') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('first_name')">{{ error.errors['first_name'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Фамилия</label>
                <input v-model.trim="last_name" type="text" class="form-control form-control-lg" :class="[ HAS_ERROR('last_name') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('last_name')">{{ error.errors['last_name'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Отчество</label>
                <input v-model.trim="middle_name" type="text" class="form-control form-control-lg" :class="[ HAS_ERROR('middle_name') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('middle_name')">{{ error.errors['middle_name'][0] }}</div>
            </div>
            <div><a href="#" @click="submit()" class="btn btn-primary btn-lg w-100">Регистрация</a></div>
            <router-link :to="{name: 'login'}" class="" tag="a">Вход</router-link>
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
            company_name: null,
            first_name: null,
            last_name: null,
            middle_name: null,
        }
    },

    computed: {
        ...mapGetters('auth', ['ERRORS', 'HAS_ERROR']),

        error() {
            return this.ERRORS;
        },

        hasErrors() {
            return this.HAS_ERRORS;
        }
    },

    methods: {
        ...mapActions('auth', ['REGISTER']),

        isError(value) {
            return this.error && this.error.errors[value] ? this.error.errors[value][0] : null;
        },

        async submit() {
            let resp = await this.REGISTER({
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                company_name: this.company_name,
                first_name: this.first_name,
                last_name: this.last_name,
                middle_name: this.middle_name
            });
            if (resp && resp.status === "ok") {
                this.$router.push({ name: 'main'});
            }
        }
    }
}
</script>

<style>

</style>
