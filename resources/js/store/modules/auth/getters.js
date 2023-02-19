export default ({
    AUTHENTICATED(state) {
        return state._authenticated || (localStorage.getItem('_authenticated') === 'true');
    },

    USER(state) {
        return state._user;
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
