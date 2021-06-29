require('./bootstrap');

window.Vue = require('vue').default;

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueLazyload from 'vue-lazyload';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const sweetAlertOptions = {
    title: 'Estás seguro(a)?',
    text: 'Esta acción no se podrá revertir',
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
    showCancelButton: true,
    showCloseButton: true,
    confirmButtonText: 'Si, eliminar registro',
    cancelButtonText: 'No, cancelar',
    showLoaderOnConfirm: true
};

Vue.use(VueToast);
Vue.use(VueLazyload)
Vue.use(VueSweetalert2, sweetAlertOptions);

require('./layout');
require("./waitMe.min.js");

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('customCard', require('./components/CustomCardComponent.vue').default);
Vue.component('searchBar', require('./components/SearchBarComponent.vue').default);
Vue.component('customModal', require('./components/CustomModalComponent.vue').default);

window.showToast = function (type, text) {
    Vue.$toast.open({
        message: text,
        type: type,
        position: 'top-right',
        duration: 4000
    });
};
