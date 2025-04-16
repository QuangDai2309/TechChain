<template>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Sửa danh mục</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" v-model="name" required>
            <div v-if="errors.name" class="text-danger mt-1">{{ errors.name }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" v-model="description" rows="3"></textarea>
          </div>

          <button type="submit" class="btn btn-primary mb-3">Cập nhật</button>

          <div v-if="errors.general" class="alert alert-danger mt-3">
            {{ errors.general }}
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      description: '',
      errors: {}
    };
  },
  async created() {
    try {
      const res = await axios.get(`http://127.0.0.1:8000/api/categories/${this.$route.params.id}`);
      this.name = res.data.name;
      this.description = res.data.description;
    } catch {
      this.errors.general = 'Không tải được thông tin danh mục.';
    }
  },
  methods: {
    async submitForm() {
      this.errors = {};
      try {
        await axios.put(`http://127.0.0.1:8000/api/categories/${this.$route.params.id}`, {
          name: this.name,
          description: this.description
        });
        this.$router.push('/admin/categories');
      } catch (error) {
        if (error.response?.status === 409) {
          this.errors.name = 'Tên danh mục đã tồn tại.';
        } else if (error.response?.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          this.errors.general = 'Có lỗi xảy ra, vui lòng thử lại.';
        }
      }
    }
  }
};
</script>
