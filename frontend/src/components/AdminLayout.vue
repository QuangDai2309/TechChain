<template>
  <div class="d-flex">
    <!-- Sidebar bên trái -->
    <nav class="bg-dark text-white sidebar d-flex flex-column p-3">
      <h4 class="text-center mb-4" style="color: white;">🌿 EcoAdmin</h4>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
          <router-link 
            class="nav-link" 
            :class="isActive('/admin')" 
            to="/admin">
            Dashboard
          </router-link>
        </li>
        <li class="nav-item mb-2">
          <router-link 
            class="nav-link" 
            :class="isActive('/admin/products')" 
            to="/admin/products">
            Quản lý sản phẩm
          </router-link>
        </li>
        <li class="nav-item mb-2">
          <router-link 
            class="nav-link" 
            :class="isActive('/admin/categories')" 
            to="/admin/categories">
            Quản lý danh mục
          </router-link>
        </li>
        <li class="nav-item mb-2">
          <router-link 
            class="nav-link" 
            :class="isActive('/admin/users')" 
            to="/admin/users">
            Quản lý người dùng
          </router-link>
        </li>
        <li class="nav-item mb-2">
          <router-link 
            class="nav-link" 
            :class="isActive('/admin/orders')" 
            to="/admin/orders">
            Quản lý đơn hàng
          </router-link>
        </li>
      </ul>
    </nav>

    <!-- Content bên phải -->
    <div class="flex-grow-1 p-4 content">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isActive(path) {
      return this.$route.path === path ? 'bg-primary text-white' : 'text-white';
    }
  }
}
</script>

<style scoped>
.sidebar {
  width: 220px;
  min-height: 100vh;
  position: fixed;
}

.content {
  margin-left: 220px;
  background-color: #f8f9fa;
  min-height: 100vh;
}
</style>
