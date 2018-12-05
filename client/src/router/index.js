import Vue from 'vue'
import Router from 'vue-router'

import Loading from '../components/loading'
import Layout from '../layout/layout.vue'

import Home from '../admin/home.vue'
import Login from '../admin/login.vue'

Vue.use(Router);

export default new Router({
  name: 'history',
  base: process.env.BABEL_ENV,
  routes: [
    {
      path: '/',
      name: 'layout',
      component: Layout
    },
    {
      path: '/loading',
      name: 'loading',
      component: Loading,
      meta: {
        keepalive:false
      }
    },
    {
      path: '/home',
      name: 'home',
      component: Home
    },{
      path: '/login',
      name: 'login',
      component: Login
    }
  ]
})
