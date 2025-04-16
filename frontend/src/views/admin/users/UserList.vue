<template>
  <div class="container mt-5">
    <h1 class="mb-4">Quản lý người dùng</h1>
    <router-link to="/admin/users/add" class="btn btn-primary mb-3">Thêm người dùng</router-link>

    <!-- Danh sách người dùng -->
    <table v-if="users.length > 0" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên</th>
          <th>Email</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            <router-link :to="{ name: 'edit-user', params: { id: user.id } }" class="btn btn-warning btn-sm">Sửa</router-link>
            <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm ml-2">Xóa</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Nếu không có người dùng -->
    <div v-if="users.length === 0" class="alert alert-warning" role="alert">
      Không có người dùng nào.
    </div>
  </div>
</template>

  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        users: [], // Danh sách người dùng
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      // Lấy danh sách người dùng
      async fetchUsers() {
        try {
          const response = await axios.get("http://127.0.0.1:8000/api/users");
          this.users = response.data;
        } catch (error) {
          console.error("Lỗi khi lấy dữ liệu người dùng:", error);
        }
      },
  
      // Xóa người dùng
      async deleteUser(userId) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`);
          this.users = this.users.filter(user => user.id !== userId);
        } catch (error) {
          console.error("Lỗi khi xóa người dùng:", error);
        }
      },
    },
  };
  </script>
  