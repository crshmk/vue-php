var Vue = require('vue');
var Router = require('vue-router');
Vue.use(Router);

var router = new Router({
  routes: [
    {
      path: '/',
      component: require('./components/Home.vue')
    },
    {
      path: '/home',
      component: require('./components/Home.vue')
    }
  ]
});
module.exports = router;
