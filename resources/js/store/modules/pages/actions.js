import store from "../../store";

export default ({
    async LIST({ getters, commit }, listData) {
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/pages/list',
                data: listData
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            commit('SET_PAGES', data.pages);
            return data;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },

    async GET({ getters, commit }, id) {

        try {
            const { data } = await axios({
                method: 'get',
                url: '/pages/' + id + '/get',
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            return data.page;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },

    async STORE({ getters, commit }, pageData) {
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/pages/store',
                data: pageData.page
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            return data;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },
    async UPDATE({ getters, commit }, pageData) {
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/pages/' + pageData.page.id + '/update',
                data: pageData.page
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            return data;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },

    async STOREDOCUMENT({ getters, commit }, pageData) {
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/document/store',
                data: pageData.document
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            return data;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },
    async UPDATEDOCUMENT({ getters, commit }, documentData) {
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/document/' + documentData.document.id + '/update',
                data: documentData.document
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            return data;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },
});
