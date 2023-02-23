import { addBlog, editBlog, loadBlogs, removeBlog } from '../../../api/blog';

export default ({
    async LOAD_BLOG({ getters, commit }, url) {
        try {
            commit('SET_LOADING_STATUS', true);
            const { data } = await loadBlogs(url);
            const { current_page, first_page_url, from, last_page, last_page_url, links, next_page_url, path, per_page, prev_page_url, to, total } = data;
            commit('SET_BLOG', data.data);
            commit('SET_PAGINATION', { current_page, first_page_url, from, last_page, last_page_url, links, next_page_url, path, per_page, prev_page_url, to, total });
            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
        } catch (error) {
            console.log(error);
            commit('SET_ERRORS', error.response.data);
        } finally {
            commit('SET_LOADING_STATUS', false);
        }
    },

    async ADD_ARTICLE({ getters, commit, dispatch, rootGetters }, blogData) {
        try {
            const { data } = await addBlog(rootGetters['auth/TOKEN'], blogData);
            console.log(data);

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }

            return true;
        } catch (error) {
            console.log(error);
            commit('SET_ERRORS', error.response.data);
            return false;
        }
    },

    async REMOVE_ARTICLE({ getters, commit, dispatch, rootGetters }, blogData) {
        try {
            const { data } = await removeBlog(rootGetters['auth/TOKEN'], {id: blogData.id});
            console.log(data);
            dispatch('LOAD_BLOG', blogData.url);

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }

            return true;
        } catch (error) {
            console.log(error);
            commit('SET_ERRORS', error.response.data);
            return false;
        }
    },

    async EDIT_ARTICLE({ getters, commit, dispatch, rootGetters }, blogData) {
        try {
            const { data } = await editBlog(rootGetters['auth/TOKEN'], blogData);
            console.log(data);

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }

            return true;
        } catch (error) {
            console.log(error);
            commit('SET_ERRORS', error.response.data);
            return false;
        }
    },
});
