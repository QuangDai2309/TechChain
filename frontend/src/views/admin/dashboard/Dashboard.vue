<template>
    <div class="container-fluid pt-4">
        <div class="row g-4">
            <!-- Tổng sản phẩm -->
            <div class="col-md-3">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Tổng sản phẩm</h5>
                            <p class="card-text fs-4">{{ stats.products }}</p>
                        </div>
                        <i class="bi bi-box-seam display-4"></i>
                    </div>
                </div>
            </div>

            <!-- Tổng đơn hàng -->
            <div class="col-md-3">
                <div class="card text-white bg-success h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Tổng đơn hàng</h5>
                            <p class="card-text fs-4">{{ stats.orders }}</p>
                        </div>
                        <i class="bi bi-cart-check display-4"></i>
                    </div>
                </div>
            </div>

            <!-- Doanh thu -->
            <div class="col-md-3">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Doanh thu</h5>
                            <p class="card-text fs-4">{{ formatCurrency(stats.revenue) }}</p>
                        </div>
                        <i class="bi bi-cash-coin display-4"></i>
                    </div>
                </div>
            </div>

            <!-- Người dùng -->
            <div class="col-md-3">
                <div class="card text-white bg-info h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Người dùng</h5>
                            <p class="card-text fs-4">{{ stats.users }}</p>
                        </div>
                        <i class="bi bi-people-fill display-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê thêm -->
        <div class="mt-5">
            <h4>Biểu đồ doanh thu</h4>
            <div class="container mt-4">
                <ChartDoanhThu />
            </div>
            <!-- <div class="alert alert-light text-center">
          Biểu đồ doanh thu sẽ được cập nhật sau.
        </div> -->
        </div>
    </div>
</template>

<script>
import ChartDoanhThu from '@/components/ChartDoanhThu.vue';
export default {
    data() {
        return {
            stats: {
                products: 128,
                orders: 320,
                revenue: 125000000,
                users: 540,
            },
        };
    },
    components: {
        ChartDoanhThu,
    },
    methods: {
        formatCurrency(value) {
            return Number(value).toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });
        },
    },
};
</script>

<style scoped>
.card {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}
</style>