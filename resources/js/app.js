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

import GAuth from 'vue-google-oauth2';
const gauthOption = {
  clientId: '500313422056-575umb00c2plivvnv6vmgsatmve2n4o0.apps.googleusercontent.com',
  scope: 'profile email',
  prompt: 'select_account',
};

Vue.use(GAuth, gauthOption);

Vue.use(VueUpload);

Vue.use(VeeValidate);

Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {


  providers: {
    facebook: {
      clientId: '3270557046503228',
      redirectUri: 'https://voluntari.ajutamsm.ro/auth/facebook/callback', // Your client app URL
    },
    google: {
      clientId: '500313422056-575umb00c2plivvnv6vmgsatmve2n4o0.apps.googleusercontent.com ',
      redirectUri: 'https://voluntari.ajutamsm.ro/auth/google/callback', // Your client app URL
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
