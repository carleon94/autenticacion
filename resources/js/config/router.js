import Vue from 'vue'
import VueRouter from 'vue-router';
import store from '../store/index';

import LoginComponent from '../components/pages/auth/LoginComponent';
import MainComponent from '../components/pages/layout/MainComponent';

import HomeComponent from '../components/pages/app/HomeComponent';
Vue.use( VueRouter )

const routes = [
    {
        path : '*',
        redirect : 'home',
    },
    {
        path : '',
        meta : { requiresAuth : true },
        component : MainComponent,
        children: [
            {
                path: '',
                name: 'home',
                component: HomeComponent,
            }
        ]
    },
    {
        path : '/login',
        name: 'login',
        meta: { guest: true },
        component : LoginComponent,
    },
]
const router = new VueRouter({
    mode: 'history',
	history : true,
    routes
})

router.beforeEach((to, from, next) => {
    if ( to.matched.some( (record) => record.meta.requiresAuth ) ) {
        if ( store.state.token ) {
            next();
            return;
        }
        console.log( 'No está autenticado el usuario' )
        next({ name: 'login'});
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if ( to.matched.some( (record) => record.meta.guest ) ) {
        if ( store.state.token ) {
            console.log( 'Ya está autenticado redireccionado al home' )
            next({ name: 'home' });
            return;
        }
        next();
    } else {
        next();
    }
});

export default router
