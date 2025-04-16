<template>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">📦 Quản lý Sản phẩm</h2>
            <router-link to="/admin/products/add" class="btn btn-primary mb-3">
                <i class="bi bi-plus-lg me-1"></i> Thêm sản phẩm
            </router-link>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="🔍 Tìm kiếm sản phẩm..." v-model="searchKeyword"
                    @input="filterProducts" />
            </div>
            <div class="col-md-6">
                <select v-model="selectedCategory" class="form-select" @change="filterProducts">
                    <option value="">Tất cả danh mục</option>
                    <option v-for="cate in categories" :value="cate.name" :key="cate.id">{{ cate.name }}</option>
                </select>
            </div>
        </div>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in paginatedProducts" :key="product.id">
                        <td>{{ index + 1 + (currentPage - 1) * itemsPerPage }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ formatPrice(product.price) }}</td>
                        <td>{{ product.description }}</td>
                        <td>
                            <img :src="`/images/products/${product.image}`" alt="Ảnh" class="img-thumbnail" width="80"
                                v-if="product.image" />
                            <span v-else class="text-muted">Không có</span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm me-2" @click="goToEdit(product.id)">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" @click="deleteProduct(product.id)">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav v-if="totalPages > 1" class="mt-3">
            <ul class="pagination justify-content-center d-flex">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <button class="page-link" @click="currentPage--">Trước</button>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                    <button class="page-link" @click="currentPage = page">{{ page }}</button>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <button class="page-link" @click="currentPage++">Sau</button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from 'axios'; // Thư viện để gọi API

export default {
    data() {
        return {
            products: [], // Danh sách tất cả sản phẩm từ API
            filteredProducts: [], // Danh sách sản phẩm sau khi lọc tìm kiếm hoặc theo danh mục
            categories: [], // Danh sách danh mục sản phẩm
            searchKeyword: '', // Từ khóa tìm kiếm
            selectedCategory: '', // Danh mục được chọn để lọc
            currentPage: 1, // Trang hiện tại
            itemsPerPage: 10, // Số sản phẩm hiển thị mỗi trang
        };
    },

    computed: {
        // Trả về danh sách sản phẩm tương ứng với trang hiện tại
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredProducts.slice(start, start + this.itemsPerPage);
        },

        // Tính tổng số trang dựa trên số lượng sản phẩm đã lọc
        totalPages() {
            return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
        },
    },

    methods: {
        // Định dạng giá thành tiền Việt (VND)
        formatPrice(value) {
            return Number(value).toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });
        },

        // Gọi API để lấy danh sách sản phẩm và gán vào products + filteredProducts
        async fetchProducts() {
            const res = await axios.get('http://127.0.0.1:8000/api/products');
            this.products = res.data;
            this.filteredProducts = res.data;
        },

        // Gọi API để lấy danh sách danh mục sản phẩm
        async fetchCategories() {
            const res = await axios.get('http://127.0.0.1:8000/api/categories');
            this.categories = res.data;
        },

        // Lọc sản phẩm theo từ khóa và danh mục
        filterProducts() {
            const keyword = this.searchKeyword.toLowerCase();
            this.filteredProducts = this.products.filter((p) => {
                const matchKeyword = p.name.toLowerCase().includes(keyword); // Có chứa từ khóa không
                const matchCategory = this.selectedCategory
                    ? p.category_name === this.selectedCategory
                    : true;
                return matchKeyword && matchCategory;
            });

            this.currentPage = 1; // Sau khi lọc thì quay về trang đầu
        },

        // Điều hướng sang trang chỉnh sửa sản phẩm
        goToEdit(id) {
            this.$router.push({ name: 'edit-product', params: { id } });
        },

        // Xóa sản phẩm và cập nhật lại danh sách
        async deleteProduct(id) {
            if (confirm('Bạn có chắc muốn xóa?')) {
                await axios.delete(`http://127.0.0.1:8000/api/products/${id}`);
                this.fetchProducts(); // Gọi lại để cập nhật danh sách
            }
        },
    },

    // Khi component được mounted, gọi API để lấy dữ liệu ban đầu
    mounted() {
        this.fetchProducts();
        this.fetchCategories();
    },
};
</script>
