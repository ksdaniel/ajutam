/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const solicitariRoutes = {
  path: '/solicitari',
  component: Layout,
  redirect: '/voluntari/lista',
  name: 'Solicitari',
  children: [
    /** Solicitari managements */
    {
      path: 'lista',
      component: () => import('@/views/solicitation_list/index'),
      name: 'Solicitari',
      meta: { title: 'Solicitari', noCache: true, icon: 'form' },

    },
  ],
};

export default solicitariRoutes;
