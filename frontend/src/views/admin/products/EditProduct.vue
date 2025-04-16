<template>
    <div class="container mt-5">
      <h2>Chỉnh sửa sản phẩm</h2>
      <form @submit.prevent="submitEditForm">
        <div class="mb-3">
          <label for="name" class="form-label">Tên sản phẩm</label>
          <input type="text" id="name" class="form-control" v-model="form.name" required />
        </div>
  
        <div class="mb-3">
          <label for="price" class="form-label">Giá</label>
          <input type="number" id="price" class="form-control" v-model="form.price" required />
        </div>
  
        <div class="mb-3">
          <label for="description" class="form-label">Mô tả</label>
          <textarea id="description" class="form-control" v-model="form.description"></textarea>
        </div>
  
        <div class="mb-3">
          <label for="category" class="form-label">Danh mục</label>
          <select id="category" class="form-control" v-model="form.category_id" required>
            <option disabled value="">-- Chọn danh mục --</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
        </div>
  
        <div class="mb-3">
          <label class="form-label">Hình ảnh</label>
          <div v-if="form.imagePreview">
            <img :src="form.imagePreview" alt="Preview" class="img-thumbnail mb-2" style="width: 120px;">
          </div>
          <input type="file" class="form-control" @change="handleImageUpload">
        </div>
  
        <button type="submit" class="btn btn-primary">Cập nhật</button>
      </form>
  
      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        form: {
          name: '',
          price: '',
          description: '',
          category_id: '',
          image: null,
          imagePreview: null,
        },
        categories: [],
        successMessage: ''
      };
    },
    async created() {
      const productId = this.$route.params.id;
      await this.fetchCategories();
      await this.fetchProduct(productId);
    },
    methods: {
      async fetchCategories() {
        try {
          const res = await axios.get('http://127.0.0.1:8000/api/categories');
          this.categories = res.data;
        } catch (error) {
          console.error("Lỗi tải danh mục:", error);
        }
      },
      async fetchProduct(id) {
        try {
          const res = await axios.get(`http://127.0.0.1:8000/api/products/${id}`);
          const p = res.data;
          this.form.name = p.name;
          this.form.price = p.price;
          this.form.description = p.description;
          this.form.category_id = p.category_id;
          this.form.imagePreview = `/images/products/${p.image}`;
        } catch (error) {
          console.error("Lỗi tải sản phẩm:", error);
        }
      },
      handleImageUpload(e) {
        const file = e.target.files[0];
        this.form.image = file;
        this.form.imagePreview = URL.createObjectURL(file);
      },
      async submitEditForm() {
        try {
          const formData = new FormData();
          formData.append('name', this.form.name);
          formData.append('price', this.form.price);
          formData.append('description', this.form.description);
          formData.append('category_id', this.form.category_id);
          if (this.form.image) {
            formData.append('image', this.form.image);
          }
  
          await axios.post(
            `http://127.0.0.1:8000/api/products/${this.$route.params.id}?_method=PUT`,
            formData,
            { headers: { 'Content-Type': 'multipart/form-data' } }
          );
  
          this.successMessage = 'Cập nhật thành công!'; 
          setTimeout(() => this.$router.push( {name: 'admin-products'} ), 1500);
        } catch (error) {
          console.error("Lỗi khi cập nhật sản phẩm:", error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 600px;
  }
  </style>
  