// ••••••••
require('./bootstrap');
import moment from 'moment'

window.Vue = require('vue');

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// all global component
Vue.component('notification', require('./components/Notification.vue').default);
// Vue.component('salary-details', require('./components/salary/employee_individual_salary/SalaryDetails').default);
Vue.prototype.moment = moment;


// create vue instance
const app = new Vue({
    el: '#app',
    created(){

    }
});
