export default [
  {
    title: 'Dashboard',
    icon: { icon: 'tabler-layout-dashboard' },
    to: 'admin-dashboard',
    action: 'manage',
    subject: 'admin',
  },
  {
    title: 'LMS Management',
    icon: { icon: 'tabler-bulb' },
    to: 'admin-lms',
    action: 'manage',
    subject: 'admin',
  },
  {
    title: 'Users',
    icon: { icon: 'tabler-user' },
    to: 'admin-users',
    action: 'manage',
    subject: 'admin',
  },
  {
    title: 'Member',
    icon: { icon: 'tabler-users' },
    to: 'admin-members',
    action: 'manage',
    subject: 'admin',
  },
  {
    title: 'Referrals',
    icon: { icon: 'tabler-books' },
    to: 'admin-referrals',
    action: 'manage',
    subject: 'admin',
  },
  {
    title: 'Plans',
    icon: { icon: 'tabler-credit-card' },
    children: [
      {
        title: 'Category',
        to: 'admin-plans-category',
        action: 'manage',
        subject: 'admin',
      },
      {
        title: 'List',
        to: 'admin-plans',
        action: 'manage',
        subject: 'admin',
      }
    ]
  },
  {
    title: 'FAQ',
    icon: { icon: 'tabler-help-hexagon' },
    to: 'admin-faqs',
    action: 'manage',
    subject: 'admin',
  },
]
