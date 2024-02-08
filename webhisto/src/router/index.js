// Composables
import { createRouter, createWebHistory } from 'vue-router'
import Default from '@/layouts/default/Default.vue';
import AdminLayout from '@/layouts/default/AdminLayout.vue';
import MedtechLayout from '@/layouts/default/MedtechLayout.vue';
import PathologistLayout from '@/layouts/default/PathologistLayout.vue';

const before_enter = (to, from, next) => {
  const userRole = localStorage.getItem('userRole');
  const userToken = localStorage.getItem('token');
  if (!userToken) {
    next();
  } else {
    if(userRole == 0){
      next('/admin');
    } else if(userRole == 30) {
      next('/medtech');
    } else if(userRole == 40) {
      next('/pathologist');
    }
  }
}

const routes = [
  {
    path: '/',
    name: 'Login',
    component: () => import('@/views/Login.vue'),
    meta: {
      layout: Default,
      requiresAuth: false,
    },
    beforeEnter: before_enter,
  },
  {
    path: '/register',
    name: 'DefaultRegister',
    component: () => import('@/views/DefaultRegister.vue'),
    meta: {
      layout: Default,
    }
  },
  {
    path: '/admin',
    name: 'AdminHome',
    component: () => import('@/views/admin/AdminHome.vue'),
    meta: {
      roles: 0,
      requiresAuth: true,
      layout: AdminLayout,
    },
    beforeEnter: (to, from, next) => {
      const userRole = JSON.parse(localStorage.getItem('userRole'));
      const userToken = localStorage.getItem('token');
      // if (to.meta.requiresAuth && !userRole) {
      if (!userToken) {
        next();
      } else {
        if(to.meta.roles == 0){
          next();
        } else {
          next();
        }
      }
    },
    children: [
      // Your other routes go here
    ]
  },
  {
    path: '/medtech',
    name: 'MedtechHome',
    component: () => import('@/views/medtech/MedtechHome.vue'),
    meta: {
      roles: ['0','30'],
      requiresAuth: true,
      layout: MedtechLayout,
    },
    beforeEnter: (to, from, next) => {
      const userRole = JSON.parse(localStorage.getItem('userRole'));
      const userToken = localStorage.getItem('token');
      // if (to.meta.requiresAuth && !userRole) {
      //   next('/');
      // } else {
      //   if (to.meta.roles && !to.meta.roles.includes(userRole)) {
      //     next('/medtech');
      //   } else {
      //     next();
      //   }
      // }
      if (!userToken) {
        next();
      } else {
        if(to.meta.roles.includes(userRole)){
          next();
        } else {
          next();
        }
      }
    },
    children: [
      // Your other routes go here
    ]
  },
  {
    path: '/pathologist',
    name: 'PathologistHome',
    component: () => import('@/views/pathologist/PathologistHome.vue'),
    meta: {
      roles: ['0','40'],
      isAuthenticated: true,
      layout: PathologistLayout,
    },
    beforeEnter: (to, from, next) => {
      const userRole = JSON.parse(localStorage.getItem('userRole'));
      const userToken = localStorage.getItem('token');
      // if (to.meta.requiresAuth && !userRole) {
      //   next('/');
      // } else {
      //   if (to.meta.roles && !to.meta.roles.includes(userRole)) {
      //     next('/medtech');
      //   } else {
      //     next();
      //   }
      // }
      if (!userToken) {
        next();
      } else {
        if(to.meta.roles.includes(userRole)){
          next();
        } else {
          next();
        }
      }
    },
    children: [
      // Your other routes go here
    ]
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router
