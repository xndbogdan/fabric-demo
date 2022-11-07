import './bootstrap';
import { createApp } from 'vue';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import Paginate from "vuejs-paginate-next";
import MainInterface from './components/MainInterface.vue'

const app = createApp({})

app.component('main-interface', MainInterface)

app.use(Toast)
app.use(Paginate)

app.mount('#app')
