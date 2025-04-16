<template>
  <div id="app" class="app-layout">
    <!-- Header chỉ hiển thị nếu không phải trang admin -->
    <Header v-if="!isAdminRoute" />

    <main class="main-content">
      <router-view />
    </main>

    <!-- Footer chỉ hiển thị nếu không phải trang admin -->
    <Footer v-if="!isAdminRoute" />
  </div>
</template>

<script>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

export default {
  name: 'App',
  components: { Header, Footer },
  data() {
    return {
      user: null
    };
  },
  async created() {
    const user = JSON.parse(sessionStorage.getItem('user'));
  if (user) {
    this.user = user; // lưu vào data nếu cần hiển thị
  }
  },
  computed: {
    isAdminRoute() {
      return this.$route.path.startsWith('/admin');
    }
  }
};
</script>



<style>
html, body, #app {
  height: 100%;
  margin: 0;
  padding: 0;
}

.app-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
}
</style>
