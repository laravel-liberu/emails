const EmailCreate = () => import('@emails/pages/emails/Create.vue');

export default {
    name: 'emails.create',
    path: 'create',
    component: EmailCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Email',
    },
};
