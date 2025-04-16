<template>
    <div class="container py-5">
        <h2 class="mb-4">Quản lý Danh mục</h2>
        <router-link to="/admin/categories/add" class="btn btn-primary mb-3">
            Thêm danh mục
        </router-link>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id">
                    <td>{{ category.name }}</td>
                    <td>{{ category.description }}</td>
                    <td>
                        <router-link :to="{ name: 'edit-category', params: { id: category.id } }"
                            class="btn btn-sm btn-warning me-2">Sửa</router-link>
                        <button class="btn btn-sm btn-danger" @click="deleteCategory(category.id)">Xóa</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Hiển thị thông báo thành công -->
        <div v-if="successMessage" class="alert alert-success mt-3 text-center">
            {{ successMessage }}
        </div>

        <!-- Hiển thị thông báo lỗi -->
        <div v-if="errorMessage" class="alert alert-danger mt-3 text-center">
            {{ errorMessage }}
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: [],
            successMessage: '',
            errorMessage: ''
        };
    },
    methods: {
        async fetchCategories() {
            try {
                const res = await axios.get('http://127.0.0.1:8000/api/categories');
                this.categories = res.data;
            } catch (err) {
                console.error('Lỗi khi tải danh mục:', err);
            }
        },
        async deleteCategory(id) {
            if (confirm('Bạn có chắc muốn xóa danh mục này?')) {
                try {
                    await axios.delete(`http://127.0.0.1:8000/api/categories/${id}`);
                    this.fetchCategories();
                    this.successMessage = 'Xóa danh mục thành công!';
                    this.errorMessage = '';

                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000);

                } catch (err) {
                    console.error('Lỗi khi xóa danh mục:', err);
                    this.errorMessage = err.response?.data?.message || 'Không thể xóa danh mục';
                    this.successMessage = '';

                    setTimeout(() => {
                        this.errorMessage = '';
                    }, 3000);
                }
            }
        }
    },
    mounted() {
        this.fetchCategories();
    }
};
</script>

