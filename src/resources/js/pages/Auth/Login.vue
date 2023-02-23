<template>
    <div class="card auth_card">
        <div class="card-body p-sm-5 m-sm-3 flex-grow-0">
            <h1 class="mb-0 fs-3">Авторизация</h1>
            <form action="#" @submit.prevent="submit()">
            <div class="mb-4">
                <label class="form-label">Email</label>
                <input v-model.trim="email" type="email" name="email" class="form-control form-control-lg" :class="[ HAS_ERROR('email') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('password')">{{ error.errors['email'][0] }}</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Пароль</label>
                <input v-model.trim="password" type="password" name="password" class="form-control form-control-lg" :class="[ HAS_ERROR('email') ? 'is-invalid' : '']">
                <div v-if="HAS_ERROR('password')">{{ error.errors['password'][0] }}</div>
            </div>
            <div><button type="submit" @click.prevent="submit()" class="btn btn-primary btn-lg w-100">Войти</button></div>
            </form>
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
        }
    },

    computed: {
        ...mapGetters('auth', ['ERRORS', 'HAS_ERROR']),

        error() {
            return this.ERRORS;
        },
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
            if (resp && resp.status === "OK") {
                this.$router.push({ name: 'main'});
            }
        }
    }
}
</script>

<style>

</style>