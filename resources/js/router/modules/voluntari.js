/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/voluntari',
  component: Layout,
  redirect: '/voluntari/inregistrare',
  name: 'Administrator',
  hidden: true,
  children: [
    /** User managements */
    {
      path: 'inregistrare',
      component: () => import('@/views/register/index'),
      name: 'Inregistrare Voluntari',
      meta: { title: 'userProfile', noCache: true },
      hidden: true,
    },
  ],
};

export default adminRoutes;
