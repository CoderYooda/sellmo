export default ({
    BLOG(state) {
        return state._blog;
    },

    GET_ARTICLE: state => id => {
        return state._blog ? state._blog.find((blog) => blog.id == id) : null;
    },

    PAGINATION(state) {
        return state._pagination;
    },

    IS_LOADING(state) {
        return state._isLoading;
    },

    ERRORS(state) {
        return state._errors;
    },

    HAS_ERRORS(state) {
        return Boolean(state._errors);
    },
});
