const EmailEdit = () => import('@emails/pages/emails/Edit.vue');

export default {
    name: 'emails.edit',
    path: ':email/edit',
    component: EmailEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Emails',
    },
};
