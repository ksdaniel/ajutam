import Vue from 'vue';
import Cookies from 'js-cookie';
import ElementUI from 'element-ui';
import App from './views/App';
import store from './store';
import router from '@/router';
import i18n from './lang'; // Internationalization
import '@/icons'; // icon
import '@/permission'; // permission control

import VueUpload from '@websanova/vue-upload';

import * as filters from './filters'; // global filters

import VeeValidate from 'vee-validate';

import VueAxios from 'vue-axios';
import VueSocialauth from 'vue-social-auth';
import axios from 'axios';

Vue.use(VueUpload);

Vue.use(VeeValidate);

Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {

  providers: {
    facebook: {
      clientId: '553013741975593',
      redirectUri: 'https://ajutam.civicsuport.ro/#/auth/facebook/callback', // Your client app URL
    },
    google: {
      clientId: '459967688656-bbevqo566u4kqp7h52nre2mj7k3gvlmj.apps.googleusercontent.com',
      redirectUri: 'https://ajutam.civicsuport.ro/auth/google/callback', // Your client app URL
    },
  },
});

Vue.use(ElementUI, {
  size: Cookies.get('size') || 'medium', // set element-ui default size
  i18n: (key, value) => i18n.t(key, value),
});

// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

Vue.config.productionTip = false;

new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App),
});
