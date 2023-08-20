export default ({
    async INDEX({ getters, commit }, request) {
        try {
            let params = {};
            prepareSortData(request, params);
            const { data } = await axios({
                method: 'GET',
                url: '/' + request.entity,
                params: params
            });

            if (getters.HAS_ERRORS) {
                commit('SET_ERRORS', null);
            }
            commit('SET_DATAGRID', data);
            return data;
        } catch (error) {
            commit('SET_DATAGRID', error.response.data);
        }
    },
});

function prepareSortData(request, params){

    let sortVals = {
        asc: 'asc',
        desc: 'desc',
    }

    if(request.params.hasOwnProperty('sort')){
        let tempSortData = request.params.sort
        params['sort[' + tempSortData.column + ']'] =  sortVals[tempSortData.value];
    }

    if(request.params.hasOwnProperty('page')){
        params['page'] =  request.params.page
    }

    if(request.params.hasOwnProperty('per_page')){
        params['perPage[eq]'] =  request.params.per_page
    }

    if(request.params.hasOwnProperty('search') && request.params.search !== ''){
        params['search[all]'] =  request.params.search
    }

    if(request.params.hasOwnProperty('filters')){
        for (let filter of request.params.filters){
            params[filter.param] = filter.value
        }
        // params['search[all]'] =  request.params.search
    }

    return request;
}
