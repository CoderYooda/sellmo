export default ({
    async FORMDATA({ getters, commit }, request) {
        try {
            let params = {};

            let url = '';
            for (let entry of request.tag.split('.')){
                url += entry + '/';
            }
            const { data } = await axios({
                method: 'GET',
                url: '/' + url + 'form_data'
            });

            commit('SET_FORMDATA', data);
            return data;
        } catch (error) {
            // commit('SET_DATAGRID', error.response.data);
        }
    },
});

