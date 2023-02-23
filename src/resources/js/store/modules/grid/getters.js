export default ({
    DATA(state) {
        return state._dataGrid === null ? [] : state._dataGrid;
    },

    ERRORS(state) {
        return state._errors;
    },

    HAS_ERRORS(state) {
        return Boolean(state._errors);
    },

    HAS_ERROR: state => slug => {
        return Boolean(state._errors && state._errors.errors[slug]);
    },
});
