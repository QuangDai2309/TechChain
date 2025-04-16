import { createApp } from 'vue';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '/public/assets/css/bootstrap.min.css';
import '/public/assets/css/main.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import App from './App.vue';
import router from './router';  // Import router từ file router/index.js
import { createPinia } from 'pinia';  // Import Pinia

// Tạo ứng dụng Vue
const app = createApp(App);

// Cài đặt router và Pinia vào ứng dụng
app.use(router);  // Cài đặt router
app.use(createPinia());  // Cài đặt Pinia

// Mount ứng dụng vào DOM
app.mount('#app');
