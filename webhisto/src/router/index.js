// Composables
import { createRouter, createWebHistory } from 'vue-router'
import Default from '@/layouts/default/Default.vue';
import AdminLayout from '@/layouts/default/AdminLayout.vue';
import MedtechLayout from '@/layouts/default/MedtechLayout.vue';
import PathologistLayout from '@/layouts/default/PathologistLayout.vue';

function isLoggedIn() {
  if(localStorage.getItem('token') !== null){
    return localStorage.getItem('token');
  }
}

function requireAuth(to, from, next) {
  const LoggedinUserRole = localStorage.getItem('userRole');
  // console.log(to);
  // console.log(LoggedinUserRole);
  // console.log(localStorage.getItem('token'));
  if (to.meta.requiresAuth && !isLoggedIn()) {
    next({ name: 'Login' });
  } else if (to.name === 'Login' && isLoggedIn() && LoggedinUserRole === '0') {
    next({ name: 'AdminHome' });
  } else if (to.name === 'Login' && isLoggedIn() && LoggedinUserRole === '30') {
    next({ name: 'MedtechHome' });
  } else if (to.name === 'Login' && isLoggedIn() && LoggedinUserRole === '45') {
    next({ name: 'PathologistHome' });
  } else {
    next(); // Proceed to the route
  }
}


const routes = [
  {
    path: '',
    name: 'Login',
    component: () => import('@/views/Login.vue'),
    meta: {
      layout: Default
    }
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '',
        name: 'AdminHome',
        component: () => import('@/views/admin/AdminHome.vue'),
      },
      {
        path: 'test_codes',
        name: 'TestCodes',
        component: () => import('@/views/admin/test_codes/Index.vue'),
      },
      {
        path: 'test_groups',
        name: 'TestGroups',
        component: () => import('@/views/admin/test_groups/Index.vue'),
      },
      {
        path: 'instruments',
        name: 'Instruments',
        component: () => import('@/views/admin/instruments/Instruments.vue'),
      },
      {
        path: 'instrument_sets',
        name: 'InstrumentSets',
        component: () => import('@/views/admin/instruments/InstrumentSets.vue'),
      },
      {
        path: 'branches',
        name: 'Branches',
        component: () => import('@/views/admin/branches/Branches.vue'),
      },
      {
        path: 'locations',
        name: 'Locations',
        component: () => import('@/views/admin/locations/Locations.vue'),
      },
      {
        path: 'users',
        name: 'Users',
        component: () => import('@/views/admin/users/Users.vue'),
      }
    ]
  },
  {
    path: '/medtech',
    component: MedtechLayout,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '',
        name: 'MedtechHome',
        component: () => import('@/views/medtech/MedtechHome.vue'),
      }
    ],
    beforeEnter: (to, from, next) => {
      const LoggedinUserRole = Number(localStorage.getItem('userRole'));
      if (isLoggedIn() && LoggedinUserRole === 30) {
        next(); // Allow access to medtech routes
      }
    }
  },
  {
    path: '/pathologist',
    component: PathologistLayout,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '',
        name: 'PathologistHome',
        component: () => import('@/views/pathologist/PathologistHome.vue'),
      }
    ]
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach(requireAuth);

export default router
