
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import { Form, HasError, AlertError } from 'vform'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
import Gate from './gate'

Vue.prototype.$gate = new Gate(window.user)

window.Form = Form
window.swal = swal
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter)

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '160px'
})

const routes = [
  { path: '/developer', component: require('./components/Developer.vue').default },
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '/users', component: require('./components/Users.vue').default }
]

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})

Vue.filter('upText',function(text){
   return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter('myDate',function(datum){
   return moment(datum).format('MMMM Do YYYY');
});

//for custom event
window.Fire = new Vue()

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


const app = new Vue({
    el: '#app',
    router
});
