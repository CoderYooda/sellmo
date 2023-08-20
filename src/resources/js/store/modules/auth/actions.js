export default ({
    async LOGIN({ getters, commit }, loginData) {
        await axios.get('/sanctum/csrf-cookie')
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/login',
                data: loginData
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            commit('SET_AUTHENTICATED', true);
            return data;
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },
    async REGISTER({ getters, commit }, registerData) {
        await axios.get('/sanctum/csrf-cookie')
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/register',
                data: registerData
            });

            commit('SET_AUTHENTICATED', true);
            return data;
            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
        } catch (error) {
            commit('SET_ERRORS', error.response.data);
        }
    },
    LOGOUT({ getters, commit }) {
        return axios({
            method: 'POST',
            url: '/logout',
        });
    },
    async WHOAMI({ getters, commit }) {
        try {
            const { data } = await axios({
                method: 'POST',
                url: '/whoami',
            });

            if(data.user){
                commit('SET_USER', data.user);
                commit('SET_AUTHENTICATED', true);
            }

            return data.user;
        } catch (error) {
            // commit('SET_AUTHENTICATED', false);
            console.log(123)
            commit('SET_ERRORS', error.response.data);
        }
    },
});
