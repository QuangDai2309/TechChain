<template>
    <div class="container mt-5">
        <h2>Thêm Sản Phẩm Mới</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" v-model="form.name" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" v-model="form.price" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" v-model="form.description" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh (URL)</label>
                <input type="file" @change="handleImageUpload" class="form-control mb-2" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Danh mục</label>
                <select class="form-control" v-model="form.category_id" required>
                    <option disabled value="">-- Chọn danh mục --</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
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
                image: '',
                category_id: ''
            },
            categories: [],
            successMessage: ''
        };
    },
    methods:
    {
        handleImageUpload(event) {
            this.form.image = event.target.files[0]; // đúng!
        },
        async fetchCategories() {
            try {
                const res = await axios.get('http://127.0.0.1:8000/api/categories');
                this.categories = res.data;
            } catch (err) {
                console.error('Không thể tải danh mục:', err);
            }
        },
        async submitForm() {
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('price', this.form.price);
                formData.append('description', this.form.description);
                formData.append('category_id', this.form.category_id);
                formData.append('image', this.form.image); // gửi file

                const response = await axios.post('http://127.0.0.1:8000/api/products', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.$router.push( { name: 'admin-products'} ); // chuyển hướng đến danh sách sản phẩm
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    alert(Object.values(errors).join('\n')); // hiện thông báo lỗi
                } else {
                    console.error(error);
                    alert('Có lỗi xảy ra!');
                }
            }
        }
    },
    created() {
        this.fetchCategories();
    },

};

</script>


<style scoped>
.container {
    max-width: 600px;
}
</style>