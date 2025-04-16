<template>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Sửa người dùng</h1>
    <form @submit.prevent="updateUser">
      <div class="form-group">
        <label for="name">Tên người dùng</label>
        <input
          v-model="editUserData.name"
          type="text"
          id="name"
          class="form-control"
          placeholder="Tên người dùng"
          required
        />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input
          v-model="editUserData.email"
          type="email"
          id="email"
          class="form-control"
          placeholder="Email"
          required
        />
      </div>

      <div class="form-group">
        <label for="password">Mật khẩu mới</label>
        <input
          v-model="editUserData.password"
          type="password"
          id="password"
          class="form-control"
          placeholder="Mật khẩu mới"
        />
      </div>

      <div class="form-group">
        <label for="password_confirmation">Xác nhận mật khẩu</label>
        <input
          v-model="editUserData.password_confirmation"
          type="password"
          id="password_confirmation"
          class="form-control"
          placeholder="Xác nhận mật khẩu"
        />
      </div>

      <button type="submit" class="btn btn-primary mb-3">Cập nhật</button>
    </form>
  </div>
</template>

  <script>
import axios from "axios";

export default {
  data() {
    return {
      editUserData: {
        id: null,
        name: "",
        email: "",
        password: "", // Thêm trường mật khẩu
        password_confirmation: "", // Thêm trường xác nhận mật khẩu
      },
    };
  },
  mounted() {
    this.fetchUserData();
  },
  methods: {
    // Lấy thông tin người dùng hiện tại
    async fetchUserData() {
      const userId = this.$route.params.id;
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/users/${userId}`);
        this.editUserData = response.data;
      } catch (error) {
        console.error("Lỗi khi lấy dữ liệu người dùng:", error);
      }
    },

    // Cập nhật thông tin người dùng (bao gồm mật khẩu)
    async updateUser() {
      // Kiểm tra mật khẩu và xác nhận mật khẩu có khớp không
      if (this.editUserData.password !== this.editUserData.password_confirmation) {
        alert("Mật khẩu không khớp!");
        return;
      }

      // Gửi yêu cầu cập nhật
      try {
        const response = await axios.put(`http://127.0.0.1:8000/api/users/${this.editUserData.id}`, {
          name: this.editUserData.name,
          email: this.editUserData.email,
          password: this.editUserData.password, // Gửi mật khẩu mới nếu có
        });

        // Quay lại trang quản lý người dùng
        this.$router.push("/admin/users");
      } catch (error) {
        console.error("Lỗi khi cập nhật người dùng:", error);
      }
    },
  },
};
</script>

  