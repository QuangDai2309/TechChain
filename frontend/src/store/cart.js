// stores/cartStore.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
  }),

  actions: {
    async fetchCart() {
      const res = await axios.get('http://127.0.0.1:8000/api/cart');
      this.items = res.data;
    },

    async addToCart(productId, quantity = 1) {
      await axios.post('http://127.0.0.1:8000/api/cart', { product_id: productId, quantity });
      this.fetchCart();
    },

    async updateQuantity(cartId, quantity) {
      await axios.put(`http://127.0.0.1:8000/api/cart/${cartId}`, { quantity });
      this.fetchCart();
    },

    async removeFromCart(cartId) {
      await axios.delete(`http://127.0.0.1:8000/api/cart/${cartId}`);
      this.fetchCart();
    },
  },
});
