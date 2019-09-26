const EmailShow = () => import('@emails/pages/emails/Show.vue');

export default {
    name: 'emails.show',
    path: ':email/show',
    component: EmailShow,
    meta: {
        breadcrumb: 'show',
        title: 'Email',
    },
};
