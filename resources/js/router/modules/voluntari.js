/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/voluntari',
  component: Layout,
  redirect: '/voluntari/list',
  name: 'Voluntari',
  meta: {
    title: 'Voluntari',
    icon: 'peoples',
  },
  children: [
    /** Voluntari managements */
    {
      path: 'inregistrare',
      component: () => import('@/views/register/new-register-form'),
      name: 'Inregistrare Voluntari',
      meta: { title: 'Inregistrare voluntari', icon: 'form', noCache: true },

    },

    /** Lista voluntari */
    {
      path: 'list',
      component: () => import('@/views/voluntari/listaVoluntari'),
      name: 'Lista Voluntari',
      meta: { title: 'Lista voluntari', noCache: true, icon: 'peoples', roles: ['admin', 'dispecer', 'coordonator'] },
    },

    /** Harta voluntari */
    {
      path: 'harta-voluntari',
      component: () => import('@/views/voluntari/index'),
      name: 'Inregistrare Voluntari',
      meta: { title: 'Harta voluntari', noCache: true, icon: 'peoples' },
    },
  ],
};

export default adminRoutes;
