export default ({
    SET_ERRORS(state, errors) {
        state._errors = errors;
    },

    SET_DATAGRID(state, pages) {
        state._dataGrid = pages;
    }
});
