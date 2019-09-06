const EmailIndex = () => import('@emails/pages/emails/Index.vue');

export default {
    name: 'emails.index',
    path: '',
    component: EmailIndex,
    meta: {
        breadcrumb: 'index',
        title: 'Emails',
    },
};
