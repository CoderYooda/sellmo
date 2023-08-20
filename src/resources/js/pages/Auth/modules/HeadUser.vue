<template>
    <div class="dropdown toolbar__item" v-click-outside="closeUserMenu">
        <button class="toolbar__user" type="button" @click="toggleUserMenu()"  :class="[ userMenu ? 'active' : '']">
                                  <span class="user__avatar">
                                      <img src="#" width="64" height="64" alt="">
                                  </span>
            <span class="user__info">
                                      <span class="user__title">{{ user.name }}</span>
                                      <span class="user__subtitle">{{ user.email }}</span>
                                  </span>
        </button>
        <ul class="dropdown-menu w-100" :class="[ userMenu ? 'active' : '']">
            <router-link :to="{name: 'company_settings'}" class="link" tag="li" @click="closeUserMenu()"><a class="dropdown-item" href="#">Организация</a></router-link>
            <li><a class="dropdown-item" href="#">Профиль</a></li>
            <li><a class="dropdown-item" href="#">Настройки</a></li>
            <li><hr class="dropdown-divider"></li>
            <li @click="logout()"><a class="dropdown-item" href="#">Выход</a></li>
        </ul>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
    name: 'HeadUser',

    data() {
        return {
            userMenu: false,
        }
    },

    computed: {
        ...mapGetters('auth', ['USER']),

        user() {
            return this.USER;
        },

        user_loaded(){
            console.log(this.user)
            return this.user !== null;
        }
    },

    mounted() {
        this.whoami();
    },

    methods: {
        ...mapActions('auth', ['LOGOUT', 'WHOAMI']),
        ...mapMutations('auth', ['SET_AUTHENTICATED']),

        async whoami() {
            let resp = await this.WHOAMI();
        },

        logout() {
            this.LOGOUT().then((resp) => {
                if (resp.data && resp.data.status === "ok") {
                    this.SET_AUTHENTICATED(false);
                    this.$router.push({ name: 'login'});
                }
            });
        },

        toggleUserMenu() {
            this.userMenu = ! this.userMenu;
            localStorage.setItem('user_menu_hidden', this.userMenu);
        },
        closeUserMenu(){
            this.userMenu = false;
            localStorage.setItem('user_menu_hidden', this.userMenu);
        },
    }
}
</script>

<style>

</style>
