export default ({
    SET_AUTHENTICATED(state, value) {
        state._authenticated = value;
        localStorage.setItem('_authenticated', value);
    },

    SET_ERRORS(state, errors) {
        state._errors = errors;
    },

    SET_USER(state, user) {
        state._user = user;
    }
});
