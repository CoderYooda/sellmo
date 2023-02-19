export default ({
    SET_ERRORS(state, errors) {
        state._errors = errors;
    },

    SET_PAGES(state, pages) {
        state._pages = pages;
    }
});
