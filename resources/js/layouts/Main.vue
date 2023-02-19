<template>
  <div class="app" :class="[ isAsideOpen ? 'sidebar_hidden' : '']" ref="app">
    <div class="aside">
      <div class="aside__base">
        <div class="aside__base__header">
          <a href="#" class="logo"></a>
        </div>
        <div class="body">
          <ul class="nav sidebar">
            <li class="section">
              <div class="title">
                <span>Главное меню</span>
              </div>
              <ul class="menu">
                <li class="item">
                    <router-link to="/" class="link"><span class="icon icon_none"></span><span class="link__title">Главная</span></router-link>
                    <router-link to="/web" class="link"><span class="icon icon_none"></span><span class="link__title">Редактор контента</span></router-link>
<!--                  <a href="/home" ></a>-->
                </li>
              </ul>
            </li>
              <li class="section">
                  <div class="title">
                      <span>Магазин</span>
                  </div>
                  <ul class="menu">
                      <li class="item">
                          <router-link :to="{name: 'ecommerce_categories'}" class="link"><span class="icon icon_none"></span><span class="link__title">Категории</span></router-link>
                          <router-link :to="{name: 'ecommerce_products'}" class="link"><span class="icon icon_none"></span><span class="link__title">Товары</span></router-link>
                          <!--                  <a href="/home" ></a>-->
                      </li>
                  </ul>
              </li>
          </ul>
        </div>
      </div>
      <div class="sidebar__shadow"></div>
    </div>
    <div class="content">
      <div class="toolbar">
        <div class="toolbar__body">
          <div class="toolbar__item">
            <button @click="toggleAside()" class="toolbar__button" type="button" :class="[ isAsideOpen ? 'active' : '']">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M1,11V9h18v2H1z M1,3h18v2H1V3z M15,17H1v-2h14V17z"></path>
              </svg>
            </button>
          </div>
          <div class="toolbar__item toolbar__search" :class="[ searchActive ? 'active' : '']">
            <form class="search">
              <div class="search__body">
                <div class="search__icon"></div>
                <input type="text" id="input-search" class="search__input" placeholder="Поиск" ref="search" @click="activateSearch()">
                <button v-if="searchActive" class="search__cancel" type="button" aria-label="Очистить поиск" @click="deActivateSearch()"></button>
                <div class="search__field"></div>
              </div>
              <div class="search__dropdown">
                <div class="search__dropdown-loader"></div>
                <div class="sa-search__dropdown-wrapper">
                  <div class="sa-search__suggestions sa-suggestions"></div>
                  <div class="sa-search__help sa-search__help--type--no-results">
                    <div class="sa-search__help-title">
                      No results for "
                      <span class="sa-search__query"></span>
                      "
                    </div>
                    <div class="sa-search__help-subtitle">Make sure that all words are spelled correctly.</div>
                  </div>
                  <div class="sa-search__help sa-search__help--type--greeting">
                    <div class="sa-search__help-title">Start typing to search for</div>
                    <div class="sa-search__help-subtitle">Products, orders, customers, actions, etc.</div>
                  </div>
                </div>
              </div>
              <div class="search__backdrop" :class="[ searchActive ? 'active' : '']" @click="deActivateSearch()"></div>
            </form>
          </div>
          <div class="mx-auto"></div>
            <HeadUser/>

        </div>
        <div class="toolbar__shadow"></div>
      </div>
      <div class="body">
        <router-view></router-view>
      </div>
      <div class="footer">Футер</div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
// import MainNav from '../components/layout/MainNav/MainNav.vue';
import HeadUser from "../pages/Auth/modules/HeadUser.vue";

export default {
    name: 'Main',

      data: function () {
        return {
            isAsideOpen: (localStorage.getItem('aside_hidden') === 'true'),
            pageLoaded: false,
            searchActive: false,
            categories: 'categories'
        }
    },

    components: { HeadUser },

    methods: {
        appKeyUp(event){
            if(event.key === 'Insert'){this.toggleAside();}
            // if(event.key === 'Escape'){this.closeUserMenu();}
        },
        toggleAside() {
            this.isAsideOpen = ! this.isAsideOpen;
            localStorage.setItem('aside_hidden', this.isAsideOpen);
        },

        activateSearch(){
            this.searchActive = true;
        },
        deActivateSearch(){
            this.searchActive = false;
            this.$refs.search.value = '';
        }
    },

    async mounted() {
        setTimeout(() => {
            this.pageLoaded = true;
        });

        setTimeout(() => {
            this.$refs['app'].style.opacity = 1;
        }, 100);



        document.addEventListener('keyup', (event) => this.appKeyUp(event));
    },
}
</script>

<style>

</style>
