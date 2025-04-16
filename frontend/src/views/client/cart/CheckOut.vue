<template>
    <div class="container my-5">
        <h2 class="mb-5 text-center fw-bold text-dark">Thanh Toán</h2>
        <form @submit.prevent="submitOrder" class="row g-4">
            <!-- Cột Form (Bên trái) -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-4">
                    <h4 class="mb-4 fw-semibold text-dark">Thông Tin Khách Hàng</h4>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Họ và Tên</label>
                        <input v-model="form.name" type="text" id="name"
                            class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Nhập họ và tên"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input v-model="form.email" type="email" id="email"
                            class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Nhập email"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-medium">Số Điện Thoại</label>
                        <input v-model="form.phone" type="tel" id="phone"
                            class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Nhập số điện thoại"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label fw-medium">Địa Chỉ</label>
                        <input v-model="form.address" type="text" id="address"
                            class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Nhập địa chỉ"
                            required />
                    </div>
                </div>
            </div>

            <!-- Cột Giỏ hàng và Tổng tiền (Bên phải) -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-4">
                    <h4 class="mb-4 fw-semibold text-dark">Giỏ Hàng</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li v-for="(item, index) in cartStore.items" :key="index"
                            class="list-group-item d-flex align-items-center py-3 border-bottom bg-transparent">
                            <img :src="`/images/products/${item.product.image}`" alt="Product image"
                                class="img-thumbnail me-3 rounded"
                                style="width: 60px; height: 60px; object-fit: cover;" />
                            <div class="flex-grow-1">
                                <span class="fw-medium text-dark">{{ item.product.name }}</span>
                                <small class="text-muted d-block">Số lượng: {{ item.quantity }}</small>
                            </div>
                            <span class="fw-semibold text-primary">{{ formatPrice(item.product.price * (1 -
                                item.product.discount / 100) * item.quantity) }}</span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <h5 class="mb-0 fw-semibold text-dark">Tổng Tiền:</h5>
                        <h5 class="mb-0 fw-bold text-primary">{{ formatPrice(totalPay()) }}</h5>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-4 rounded-3 shadow-sm">Xác Nhận Đặt
                    Hàng</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '@/store/cart'; // Nhập store từ cartStore

export default {
    name: 'CheckoutPage',

    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                address: ''
            },
            cartStore: useCartStore()  // Khởi tạo store để sử dụng trong component
        };
    },

    methods: {
        // Kiểm tra giỏ hàng bằng console log
        consoleCart() {
            console.log(this.cartStore.items); // In ra giỏ hàng để kiểm tra
        },

        // Tính tổng tiền từ giỏ hàng (không dùng computed)
        totalPay() {
            return this.cartStore.items.reduce((total, item) => {
                // Tính giá sau giảm giá
                const price = item.product.price * (1 - item.product.discount / 100);
                return total + price * item.quantity;
            }, 0);
        },

        // Định dạng giá trị tiền tệ
        formatPrice(value) {
            return value.toLocaleString('vi-VN') + 'đ';
        },

        // Xử lý khi người dùng đặt hàng
        async submitOrder() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/checkout', {
                    ...this.form,
                    cart: this.cartStore.items
                });

                if (response.status === 200) {
                    alert('✅ Đặt hàng thành công!');

                    try {
                        // Gọi API xóa giỏ hàng trên server
                        const clearCartResponse = await axios.delete('http://127.0.0.1:8000/api/cart/clear/1');

                        // Kiểm tra nếu xóa thành công
                        if (clearCartResponse.status === 200) {
                            // Xóa giỏ hàng trong store (client-side)
                            this.cartStore.items = [];
                            this.$router.push('/'); // Quay về trang chủ
                        } else {
                            alert('❌ Không thể xóa giỏ hàng.');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('❌ Đã xảy ra lỗi khi xóa giỏ hàng.');
                    }
                }

            } catch (error) {
                // Kiểm tra nếu server có trả về lỗi
                if (error.response) {
                    const status = error.response.status;
                    const data = error.response.data;

                    console.error('Chi tiết lỗi từ server:', data);

                    // Gợi ý hiển thị lỗi cho người dùng
                    if (status === 422) {
                        // Laravel validation error thường là 422
                        const messages = Object.values(data.errors || {}).flat().join('\n');
                        alert('❌ Lỗi xác thực:\n' + messages);
                    } else if (status === 500) {
                        alert('❌ Lỗi máy chủ! Vui lòng thử lại sau.');
                    } else {
                        alert(`❌ Lỗi không xác định (${status}):\n` + JSON.stringify(data));
                    }
                } else {
                    // Lỗi không phản hồi từ server (network, timeout...)
                    alert('❌ Không thể kết nối tới máy chủ!');
                    console.error('Lỗi không phản hồi:', error.message);
                }
            }
        },


        // Lấy giỏ hàng từ API
        async fetchCart() {
            try {
                await this.cartStore.fetchCart(); // Lấy giỏ hàng từ API
                console.log('Giỏ hàng đã được tải:', this.cartStore.items); // Kiểm tra dữ liệu giỏ hàng
            } catch (error) {
                console.error('Có lỗi khi tải giỏ hàng:', error);
            }
        }
    },

    // Gọi hàm fetchCart khi component được mounted
    async mounted() {
        await this.fetchCart();
    }
};
</script>
