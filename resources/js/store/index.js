import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        user: JSON.parse( localStorage.getItem('user') ) || null,
        token: localStorage.getItem('token') || null,
    },

    getters: {
        isAuthenticated: state => !!state.token,
        getUser: state => state.user,
    },

    actions: {
        login( { commit , dispatch } , credentials ) {
            return new Promise( (resolve, reject) => {
                axios.post( '/auth/login' , credentials )
                    .then( response => {
                        if( response.data.status ) {
                            commit( 'SET_AUTH_DATA' , response.data )
                        } else {
                            commit( 'CLEAR_AUTH_DATA' )
                        }
                        resolve( response.data )
                    })
                    .catch( err => {
                        reject( err )
                    });
            })
        },
        logout( { commit } ) {
            return new Promise( (resolve, reject) => {
                axios.post( '/auth/logout' )
                    .then( response => {
                        commit('CLEAR_AUTH_DATA');
                        resolve( response.data )
                    })
                    .catch( err => {
                        reject( err )
                    })
            })
        },
        refreshToken( { commit } ) {
            return new Promise( (resolve, reject) => {
                axios.post( '/auth/refresh' )
                    .then( response => {
                        if( response.data.status ) {
                            commit( 'SET_REFRESHED_TOKEN' , response.data.token )
                        }
                        resolve( response.data )
                    })
                    .catch( err => {
                        reject( err )
                    })
            })
        },
    },

    mutations: {
        SET_AUTH_DATA( state , data ) {
            localStorage.setItem( 'token' , data.token )
            localStorage.setItem( 'user' , JSON.stringify( data.user ) )
            axios.defaults.headers.common['Authorization'] = 'Bearer '+data.token
            state.token = data.token
            state.user = data.user
        },
        CLEAR_AUTH_DATA( state ) {
            localStorage.clear()
            delete axios.defaults.headers.common['Authorization']
            state.token = null
            state.user = null
        },
        SET_REFRESHED_TOKEN( state, token ) {
            localStorage.setItem( 'token' , token )
            state.token = token
            axios.defaults.headers.common['Authorization'] = 'Bearer '+token
        },        
    },
})

export default store;