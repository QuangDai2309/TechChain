
<template>
  <div class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center mb-4">Đăng ký</h3>
    <form @submit.prevent="register">
      <div class="mb-3">
        <label>Email</label>
        <input v-model="form.email" type="email" class="form-control" required />
      </div>

      <div class="mb-3">
        <label>Name</label>
        <input v-model="form.name" type="text" class="form-control" required />
      </div>

      <div class="mb-3">
        <label>Mật khẩu</label>
        <input v-model="form.password" type="password" class="form-control" required />
      </div>

      <div class="mb-3">
        <label>Nhập lại mật khẩu</label>
        <input v-model="form.password_confirmation" type="password" class="form-control" required />
      </div>

      <button type="submit" class="btn btn-primary w-100">Đăng ký</button>

      <p class="text-center mt-3">
        <router-link to="/login">Đã có tài khoản? Đăng nhập</router-link>
      </p>

      <div v-if="message" class="alert alert-info mt-3 text-center">{{ message }}</div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        email: '',
        name: '',
        password: '',
        password_confirmation: ''
      },
      message: ''
    };
  },
  methods: {
    async register() {
      try {
        // await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');
        await axios.post('http://127.0.0.1:8000/api/register', this.form);
        this.message = 'Đăng ký thành công! Bạn có thể đăng nhập.';
        this.$router.push('/login');
      } catch (err) {
        this.message = err.response?.data?.message || 'Đăng ký thất bại!';
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