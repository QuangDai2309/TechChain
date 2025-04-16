<template>
    <div class="container mt-5">
      <h2 class="mb-4 text-center text-primary fw-bold">📦 Quản lý Đơn Hàng</h2>
  
      <!-- Danh sách đơn hàng -->
      <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Người đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders" :key="order.id">
                <td>{{ order.id }}</td>
                <td class="fw-semibold">{{ order.name }}</td>
                <td class="text-success">{{ formatPrice(parseFloat(order.total)) }}</td>
                <td>
                  <span
                    class="badge"
                    :class="{
                      'bg-warning text-dark': order.status === 'pending',
                      'bg-success': order.status === 'completed',
                      'bg-danger': order.status === 'canceled'
                    }"
                  >
                    {{
                      order.status === 'pending'
                        ? 'Đang xử lý'
                        : order.status === 'completed'
                        ? 'Hoàn thành'
                        : 'Hủy'
                    }}
                  </span>
                </td>
                <td class="text-center">
                  <button @click="viewOrder(order.id)" class="btn btn-sm btn-outline-info me-1">
                    <i class="bi bi-eye"></i> Chi tiết
                  </button>
                  <button @click="updateStatus(order.id, 'completed')" class="btn btn-sm btn-outline-success me-1">
                    <i class="bi bi-check-circle"></i>
                  </button>
                  <button @click="updateStatus(order.id, 'canceled')" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-x-circle"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <!-- Modal hiển thị chi tiết đơn hàng -->
      <div v-if="selectedOrder" class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.4);">
        <div class="modal-dialog modal-lg">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
              <h5 class="modal-title">Chi tiết Đơn hàng #{{ selectedOrder.id }}</h5>
              <button type="button" class="btn-close btn-close-white" @click="selectedOrder = null"></button>
            </div>
            <div class="modal-body">
              <p><strong>👤 Người đặt:</strong> {{ selectedOrder.name }}</p>
              <p><strong>📧 Email:</strong> {{ selectedOrder.email }}</p>
              <p><strong>📍 Địa chỉ:</strong> {{ selectedOrder.address }}</p>
              <p><strong>📞 Số điện thoại:</strong> {{ selectedOrder.phone }}</p>
              <h5 class="mt-4">🛒 Danh sách sản phẩm:</h5>
              <ul class="list-group">
                <li
                  v-for="item in selectedOrder.order_items"
                  :key="item.id"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  {{ item.product.name }} (x{{ item.quantity }})
                  <span class="fw-bold text-success">{{ formatPrice(item.price * item.quantity) }}</span>
                </li>
              </ul>
              <p class="mt-3"><strong>💰 Tổng tiền:</strong> <span class="text-danger fw-bold">{{ formatPrice(parseFloat(selectedOrder.total)) }}</span></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="selectedOrder = null">Đóng</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  


<script>
import axios from 'axios';

export default {    
    data() {
        return {
            orders: [], // Danh sách đơn hàng
            selectedOrder: null, // Đơn hàng chi tiết được chọn
        };
    },

    methods: {
        // Lấy danh sách đơn hàng
        async fetchOrders() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/orders');
                this.orders = response.data;
                console.log(this.orders); // In danh sách đơn hàng ra console
            } catch (error) {
                console.error('Có lỗi khi tải danh sách đơn hàng:', error);
            }
        },

        // Xem chi tiết đơn hàng
        async viewOrder(id) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/orders/${id}`);
                this.selectedOrder = response.data;
            } catch (error) {
                console.error('Có lỗi khi tải chi tiết đơn hàng:', error);
            }
        },

        // Cập nhật trạng thái đơn hàng
        async updateStatus(id, status) {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/orders/${id}/status`, { status });
                alert('Trạng thái đơn hàng đã được cập nhật!');
                this.fetchOrders(); // Tải lại danh sách đơn hàng
            } catch (error) {
                console.error('Có lỗi khi cập nhật trạng thái đơn hàng:', error);
            }
        },

        // Định dạng giá trị tiền tệ
        formatPrice(value) {
            return value.toLocaleString('vi-VN') + 'đ';
        }
    },

    mounted() {
        this.fetchOrders(); // Lấy danh sách đơn hàng khi trang được tải
    }
};
</script>

