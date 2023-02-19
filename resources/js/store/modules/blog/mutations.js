export default ({
    SET_BLOG(state, blog) {
        state._blog = blog;
    },

    SET_PAGINATION(state, pagination) {
        state._pagination = pagination;
    },

    SET_LOADING_STATUS(state, status) {
        state._isLoading = status;
    },

    SET_ERRORS(state, errors) {
        state._errors = errors;
    },
});
