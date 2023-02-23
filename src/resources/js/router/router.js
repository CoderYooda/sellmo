import { createRouter, createWebHistory } from 'vue-router';
import store from '../store/store';

const routes = [
    {
        path: '/',
        name: 'main',
        component: () => import('../pages/Main.vue'),
        meta: {
            layout: 'Main',
            auth: true,
        }
    }, {
        path: '/login',
        name: 'login',
        component: () => import('../pages/Auth/Login.vue'),
        meta: {
            layout: 'Auth',
            auth: false,
            redirectIfAuthenticated: true
        }
    }, {
        path: '/register',
        name: 'register',
        component: () => import('../pages/Auth/Register.vue'),
        meta: {
            layout: 'Auth',
            auth: false,
            redirectIfAuthenticated: true
        }
    }, {
        path: '/web',
        name: 'web',
        component: () => import('../pages/Web/PageList.vue'),
        meta: {
            layout: 'Main',
            auth: true,
        },
    },
    {
        path: '/web/pages',
        name: 'page_form',
        meta: {layout: 'Main', auth: true},
        component: () => import(/* webpackChunkName: "PageForm" */ '../pages/Web/PageForm.vue'),
    },
    {
        path: '/web/pages/:page_id?/edit',
        name: 'page_edit',
        props: true,
        meta: {layout: 'main'},
        component: () => import(/* webpackChunkName: "PageFormEdit" */ '../pages/Web/PageForm.vue'),
    },
    {
        path: '/web/pages/:page_id?/documents/:document_id?/edit',
        name: 'document_edit',
        props: true,
        meta: {layout: 'main'},
        component: () => import(/* webpackChunkName: "DocumentFormEdit" */ '../pages/Web/DocumentForm.vue'),
    },
    {
        path: '/ecommerce/categories',
        name: 'ecommerce_categories',
        props: true,
        meta: {layout: 'main'},
        component: () => import(/* webpackChunkName: "DocumentFormEdit" */ '../pages/Ecommerce/Category/Categories.vue'),
    },
    {
        path: '/ecommerce/products',
        name: 'ecommerce_products',
        props: true,
        meta: {layout: 'main'},
        component: () => import('../pages/Ecommerce/Product/Products.vue'),
    },
    {
        path: '/company/settings',
        name: 'company_settings',
        props: true,
        meta: {layout: 'main'},
        component: () => import(/* webpackChunkName: "CompanySettings" */'../pages/Ecommerce/Company/Settings.vue'),
    },
];

const router = createRouter({
    history: createWebHistory('/admin/'),
    routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
    if (to.meta.auth && !store.getters['auth/AUTHENTICATED']) {
        next({ name: 'login' });
    } else if (to.meta.redirectIfAuthenticated && store.getters['auth/AUTHENTICATED']) {
        next(from);
    } else {
        next();
    }
});

export default router;
