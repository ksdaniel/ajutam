/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const solicitariRoutes = {
  path: '/solicitari',
  component: Layout,
  redirect: '/voluntari/lista',
  name: 'Solicitari',
  meta: {
    title: 'Solicitari',
    icon: 'form',
    roles: ['admin', 'dispecer', 'coordonator'],
  },
  children: [
    /** Solicitari managements */
    {
      path: 'lista',
      component: () => import('@/views/solicitation_list/index'),
      name: 'Lista solicitari',
      meta: { title: 'Solicitari', noCache: true, icon: 'form', roles: ['admin', 'dispecer', 'coordonator'] },

    },
    /** Solicitari managements */
    {
      path: 'add',
      component: () => import('@/views/solicitation_list/add'),
      name: 'AddSolicitare',
      meta: { title: 'Adauga Solicitare', noCache: true, icon: 'form', roles: ['admin', 'dispecer', 'coordonator'] },
      hidden: true,

    },
    {
      path: 'edit/:id',
      component: () => import('@/views/solicitation_list/edit'),
      name: 'EditSolicitare',
      meta: { title: 'Modifica Solicitare', noCache: true, icon: 'pencil', roles: ['admin', 'dispecer', 'coordonator'] },
      hidden: true,

    },
  ],
};

export default solicitariRoutes;
