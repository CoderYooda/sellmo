export default ({
    SET_ERRORS(state, errors) {
        state._errors = errors;
    },

    SET_FORMDATA(state, form_data) {
        state._form_data = form_data;
    }
});
