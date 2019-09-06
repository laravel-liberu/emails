import routeImporter from '@core-modules/importers/routeImporter';

const routes = routeImporter(require.context('./emails', false, /.*\.js$/));
const RouterView = () => import('@core-pages/Router.vue');

export default {
    path: '/emails',
    component: RouterView,
    meta: {
        breadcrumb: 'emails',
        route: 'emails.index',
    },
    children: routes,
};
