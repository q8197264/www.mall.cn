import Vue from 'vue'
import Router from 'vue-router'

import Layout from '../layout/Layout.vue'

Vue.use(Router)

export const constRouterMap = [
  {
    path: '/loading',
    name: 'loading',
    component: () => import('@/components/loading'),
    meta: {title: '载入页面...', icon: 'sms-hot', keepalive: false}
  },
  {path: '/login', name: 'login', component: () => import('@/views/login/login'), hidden: true},
  {path: '/404', component: () => import('@/views/404'), hidden: true},
  {
    path: '',
    component: Layout,
    redirect: '/home',
    children: [{
      path: 'home',
      name: 'home',
      component: () => import('@/views/home/home'),
      meta: {title: '首页', icon: 'home'}
    }]
  }
]

export default new Router({
  // mode: 'history', //后端支持可开
  scrollBehavior: () => ({y: 0}),
  base: process.env.BABEL_ENV,
  routes: constRouterMap
})
