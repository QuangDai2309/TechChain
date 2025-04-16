<template>
    <div>

        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="index.html">Shop</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- Shopping Cart -->
        <div class="shopping-cart section">
            <div class="container">
                <div class="cart-list-head">
                    <!-- Cart List Title -->
                    <div class="cart-list-title">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-12">

                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <p>Product Name</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Quantity</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Subtotal</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Discount</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <p>Remove</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Cart List Title -->
                    <!-- Cart Single List list -->
                    <div class="cart-single-list" v-for="item in cart.items" :key="item.id">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="product-details.html"><img :src="`/images/products/${item.product.image}`"
                                        alt="#"></a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name"><a href="product-details.html">
                                        {{ item.product.name }}</a></h5>
                                <!-- <p class="product-des">
                                    <span><em>Type:</em> Mirrorless</span>
                                    <span><em>Color:</em> Black</span>
                                </p> -->
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input">
                                    <select class="form-control" v-model.number="item.quantity"
                                        @change="() => updateQuantity(item)">
                                        <option v-for="i in 5" :key="i" :value="i">{{ i }}</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ formatPrice((item.product.price * item.quantity))
                                }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ item.product.discount }}%</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a @click="removeItem(item.id)" class="remove-item" href="javascript:void(0)"><i
                                        class="lni lni-close"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- Total Amount -->
                        <div class="total-amount">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-12">
                                    <div class="left">
                                        <div class="coupon">
                                            <form action="#" target="_blank">
                                                <input name="Coupon" placeholder="Enter Your Coupon">
                                                <div class="button">
                                                    <button class="btn">Apply Coupon</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="right">
                                        <ul>
                                            <p>Cart Subtotal: {{ formatPrice(cartSubtotal) }}</p>
                                            <p>Shipping: Free</p>
                                            <p>You Save: {{ formatPrice(totalDiscount) }}</p>
                                            <p>You Pay: {{ formatPrice(totalPay) }}</p>
                                        </ul>
                                        <div class="button">
                                            <a href="checkout.html" class="btn">Checkout</a>
                                            <a href="product-grids.html" class="btn btn-alt">Continue shopping</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ End Total Amount -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Shopping Cart -->
    </div>
</template>

<script>
import { useCartStore } from '@/store/cart.js';

export default {
    name: 'CartPage',
    data() {
        return {
            cart: useCartStore(),
            cartSubtotal: 0,
            totalDiscount: 0,
            totalPay: 0,
        };
    },
    methods: {
        formatPrice(value) {
            return value.toLocaleString('vi-VN') + 'đ';
        },
        calculateTotals() {
            let subtotal = 0;
            let discount = 0;

            this.cart.items.forEach(item => {
                const itemTotal = item.product.price * item.quantity;
                const itemDiscount = itemTotal * (item.product.discount / 100);

                subtotal += itemTotal;
                discount += itemDiscount;
            });

            this.cartSubtotal = subtotal;
            this.totalDiscount = discount;
            this.totalPay = subtotal - discount;
        },
        async updateQuantity(item) {
            await this.cart.updateQuantity(item.id, item.quantity);
            this.calculateTotals();
        },
        async removeItem(id) {
            await this.cart.removeFromCart(id);
            await this.cart.fetchCart(); // cập nhật lại giỏ hàng sau khi xóa
            this.calculateTotals();
        }

    },
    async mounted() {
        await this.cart.fetchCart();
        this.calculateTotals();
    }
};
</script>
