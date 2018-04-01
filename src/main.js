var Vue = require('vue');
var App = require('./App.vue');

var router = require('./router');
var http = require('./plugins/http');

Vue.use(http);

new Vue({
  el: '#app',
  router: router,
  render: h => h(App)
});
