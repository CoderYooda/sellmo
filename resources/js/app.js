import axios from "axios";
window.axios = axios;
if (window.axios) {
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}
// import '@imengyu/vue3-context-menu/lib/vue3-context-menu.css'
import ContextMenu from '@imengyu/vue3-context-menu'

import DataGridTable from "./components/DataGrid/Table.vue";
import DataForm from "./components/DataForm/DataForm.vue";
import { vue3Debounce } from 'vue-debounce'
import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router';
import store from './store/store';

let app = createApp(App)
    .use(store)
    .use(router);


window.axios.interceptors.response.use(  (response) => {

    // if(response.data.hasOwnProperty('redirect')){
    //     if(confirm( response.data.redirect_message ?? 'Перейти по адресу ' + response.data.redirect  ))
    //         window.open(response.data.redirect, '_blank');
    // }

    return response;
}, function (error) {
    if(error.response.status === 401 || error.response.status === 419 ) {
        store.commit('auth/SET_AUTHENTICATED', false);
        router.push({ name: 'login' });
    }
    return Promise.reject(error);
});
app.component("DataGridTable", DataGridTable);
app.component("DataForm", DataForm);
app.use(ContextMenu);
app.directive('debounce', vue3Debounce({ lock: true }))
app.directive('click-outside', {
    mounted(el, binding, vnode) {
        el.clickOutsideEvent = function(event) {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value(event, el);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    unmounted(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    }
});

app.mount('#app');

Array.prototype.unique = function() {
    let a = this.concat();
    for(let i = 0; i < a.length; ++i) {
        for(let j = i+1; j < a.length; ++j) {
            if(a[i] === a[j])
                a.splice(j--, 1);
        }
    }
    return a;
};
