window.Vue = require('vue');
import App from './app.vue';
var app = new Vue({
    el: '#app',
    render: h =>h(App)
  });