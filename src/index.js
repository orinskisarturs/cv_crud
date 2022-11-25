import Vue from 'vue';
import App from './App.vue';
import router from './router';
import VueI18n from 'vue-i18n';
import lv from './i18n/lv.json';
import './scss/index.scss';

Vue.use(VueI18n);
const messages = {
    lv: lv
}

const i18n = new VueI18n({
    locale: 'lv',
    messages,
})

new Vue({
    router,
    i18n,
    render: (h) => h(App),
}).$mount('#app');
