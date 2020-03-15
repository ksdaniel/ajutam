/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/voluntari',
  component: Layout,
  redirect: '/voluntari/harta-voluntari',
  name: 'Voluntari',
  children: [
    /** Voluntari managements */
    {
      path: 'inregistrare',
      component: () => import('@/views/register/index'),
      name: 'Inregistrare Voluntari',
      meta: { title: 'Inregistrare voluntari', noCache: true },
      hidden: true,
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
