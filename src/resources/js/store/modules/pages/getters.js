export default ({
    PAGES(state) {
        return state._pages === null ? [] : state._pages.collection;
    },

    PAGE : (state) => (id) => {
        return state._pages.collection.filter(item => item.id === id)[0];
    },

    DOCUMENT : (state) => (page_id, document_id) => {
        return state._pages.collection.filter(item => item.id === page_id)[0].filter(item => item.id === document_id)[0];
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
