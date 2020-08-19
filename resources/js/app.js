require('./bootstrap');
window.Vue = require('vue');

//PLUGINS
import moment from 'moment';
import PortalVue from 'portal-vue';
import Vuelidate from 'vuelidate';
import Vue from 'vue';
import VueIziToast from 'vue-izitoast';
import ImageUploader from 'vue-image-upload-resize';
import 'vue-search-select/dist/VueSearchSelect.css';
import Datepicker from 'vuejs-datepicker';
import { ModelSelect } from 'vue-search-select';
import VueCurrencyFilter from 'vue-currency-filter';
import money from 'v-money';
import 'iv-viewer/dist/iv-viewer.css';

import DashboardComponent from './components/DashboardComponent';
import LoginComponent from './components/auth/LoginComponent';
import PageComponent from './components/pages/PageComponent';
import PermissionComponent from './components/permissions/PermissionComponent';
import RoleComponent from './components/permissions/RoleComponent';
import FormRole from './components/permissions/FormRole';
import UserComponent from './components/users/UserComponent';
import FormUser from './components/users/FormUser';
import ReferenceComponent from './components/references/ReferenceComponent';

//IMPORT UI
import ButtonComponent from './components/ui/ButtonComponent';
import MenuSidebar from './components/ui/MenuSidebar';
import TableComponent from './components/ui/TableComponent';
import ModalComponent from './components/ui/ModalComponent';

Vue.component('dashboard-component', DashboardComponent);
Vue.component('login-component', LoginComponent);
Vue.component('page-component', PageComponent);
Vue.component('permission-component', PermissionComponent);
Vue.component('role-component', RoleComponent);
Vue.component('form-role', FormRole);
Vue.component('user-component', UserComponent);
Vue.component('form-user', FormUser);
Vue.component('reference-component', ReferenceComponent);

//UI Component maninback 2019
Vue.component('button-component', ButtonComponent);
Vue.component('menu-sidebar', MenuSidebar);
Vue.component('table-component', TableComponent);
Vue.component('modal-component', ModalComponent);
Vue.component('datepicker', Datepicker);
Vue.component('model-select', ModelSelect);

moment.locale('id');
Vue.use(PortalVue);
Vue.use(Vuelidate);
Vue.use(VueIziToast);
Vue.use(ImageUploader);
Vue.use(require('vue-moment'), {
    moment
});
Vue.use(VueCurrencyFilter,
{
    symbol : 'Rp',
    thousandsSeparator: '.',
    fractionCount: 0,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
});
Vue.use(money, {
    decimal: '',
    thousands: '.',
    prefix: '',
    sufflix: '',
    precision: 0,
    masked: false
});
Vue.prototype.$eventBus = new Vue();
const app = new Vue({
    el: '#app'
});

