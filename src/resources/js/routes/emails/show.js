const EmailShow = () => import('@emails/pages/emails/Show.vue');

export default {
    name: 'emails.show',
    path: ':email',
    component: EmailShow,
    meta: {
        breadcrumb: 'show',
        title: 'Emails Profile',
    },
};
