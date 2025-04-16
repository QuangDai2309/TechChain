<template>
  <div class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center mb-4">Đăng nhập</h3>
    <form @submit.prevent="loginUser">
      <div class="mb-3">
        <label>Email</label>
        <input v-model="email" type="email" class="form-control" required />
      </div>

      <div class="mb-3">
        <label>Mật khẩu</label>
        <input v-model="password" type="password" class="form-control" required />
      </div>

      <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

      <p class="text-center mt-3">
        <router-link to="/register">Chưa có tài khoản? Đăng ký</router-link>
      </p>

      <div v-if="message" class="alert alert-info mt-3 text-center">{{ message }}</div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import eventBus from '@/store/eventBus.js';
export default {
  data() {
    return {
      email: '',
      password: '',
      message: ''
    };
  },
  methods: {
    async loginUser() {
      try {
        // // 1. Lấy CSRF cookie trước khi gửi request
        // await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', {
        //   withCredentials: true
        // });

        // 2. Gửi yêu cầu đăng nhập và nhận thông tin người dùng luôn
        const loginRes = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password
        }, {
          withCredentials: true
        });

        // 3. Lấy user từ response trả về
        const user = loginRes.data.user;

        // ✅ Lưu thông tin user vào sessionStorage
        sessionStorage.setItem('user', JSON.stringify(user));

        this.message = 'Đăng nhập thành công!';

        eventBus.emit('user-logged-in');
        console.log('Người dùng:', user);

        // 👉 Chuyển hướng nếu cần
        alert('Đăng nhập thành công!');
        this.$router.push('/');
        
      } catch (err) {
        this.message = err.response?.data?.message || 'Lỗi đăng nhập!';
        console.error(err);
      }
    }
  }
};

</script>

<style scoped>
.container {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  padding: 20px;
}
</style>
