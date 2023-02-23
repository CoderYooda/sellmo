import { createStore } from 'vuex';
import auth from './modules/auth/auth';
import pages from './modules/pages/pages';
import grid from './modules/grid/grid';
import form from './modules/form/form';
// import blog from './modules/blog/blog';

export default createStore({
  state: {
  },
  getters: {
    LOADING(state) {
      return Boolean(state._app_loading);
    },
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    auth,
    pages,
    grid,
    form,
    // blog
}
})


