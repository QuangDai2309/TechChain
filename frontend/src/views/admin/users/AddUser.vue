<template>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Thêm người dùng</h1>
    <form @submit.prevent="addUser">
      <div class="form-group">
        <label for="name">Tên người dùng</label>
        <input v-model="newUser.name" type="text" id="name" class="form-control" placeholder="Tên người dùng" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="newUser.email" type="email" id="email" class="form-control" placeholder="Email" required />
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input v-model="newUser.password" type="password" id="password" class="form-control" placeholder="Mật khẩu" required />
      </div>
      <button type="submit" class="btn btn-primary btn-block">Thêm người dùng</button>
    </form>
  </div>
</template>

  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        newUser: {
          name: "",
          email: "",
          password: "",
        },
      };
    },
    methods: {
      async addUser() {
        try {
          const response = await axios.post("http://127.0.0.1:8000/api/users", this.newUser);
          this.$router.push("/admin/users"); // Quay lại trang quản lý người dùng sau khi thêm thành công
        } catch (error) {
          console.error("Lỗi khi thêm người dùng:", error);
        }
      },
    },
  };
  </script>
  


  <style scoped>
.container {
  max-width: 600px;
}
</style>