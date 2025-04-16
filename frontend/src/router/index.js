// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
// --------------Client views---------------
// --------------Home views---------------
import Home from '../views/client/page/Home.vue';
// --------------Product views---------------
import ClientProductList from '../views/client/product/ProductsList.vue';
import ProductDetail from '../views/client/product/ProductDetail.vue';
// --------------Auth views---------------
import Login from '../views/client/auth/Login.vue';
import Register from '../views/client/auth/Register.vue';
import User from '../views/client/auth/user.vue';
// --------------Cart views---------------
import Cart from '../views/client/cart/Cart.vue';
import CheckOut from '../views/client/cart/CheckOut.vue';

// --------------Admin views--------------
// --------------Dashboard views--------------
import AdminLayout from '../components/AdminLayout.vue';
import Dashboard from '../views/admin/dashboard/Dashboard.vue';

// --------------Product views--------------
import AdminProductList from '../views/admin/products/ProductList.vue';
import AddProduct from '../views/admin/products/AddProduct.vue'
import EditProduct from '../views/admin/products/EditProduct.vue';

//--------------Category views--------------
import CategoryList from '../views/admin/categories/CategoryList.vue';
import AddCategory from '../views/admin/categories/AddCategory.vue';
import EditCategory from '../views/admin/categories/EditCategory.vue';

// --------------User views--------------
import AdminUserList from '../views/admin/users/UserList.vue';
import AddUser from '../views/admin/users/AddUser.vue';
import EditUser from '../views/admin/users/EditUser.vue';

// --------------Order views--------------
import OrderList from '../views/admin/orders/OrderManagement.vue';
import OrderManagement from '../views/admin/orders/OrderManagement.vue';

// Định nghĩa các route
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  // Product routes
  {
    path: '/products',
    name: 'client-products',
    component: ClientProductList,
  },
  {
    path: '/products/:id',
    name: 'product-detail',
    component: ProductDetail,
  },
  // Auth routes
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
  },
  {
    path: '/user',
    name: 'user',
    component: User,
  },
  // Cart routes
  {
    path: '/cart',
    name: 'cart',
    component: Cart,
  },
  {
    path: '/checkout',
    name: 'checkout',
    component: CheckOut,
  },

  // Admin routes
  {
    path: '/admin',  
    name: 'AdminLayout',
    component: AdminLayout,
    children: [
      // Dashboard routes
      {
        path: '',
        name: 'dashboard',  
        component: Dashboard,
      },
      // Product routes
      {
        path: 'products',
        name: 'admin-products',
        component: AdminProductList,
      },
      {
        path: 'products/add',
        name: 'add-product',
        component: AddProduct,
      },
      {
        path: 'products/edit/:id',
        name: 'edit-product',
        component: EditProduct,
      },
      // Category routes
      {
        path: 'categories',
        name: 'category-list',
        component: CategoryList,
      },
      {
        path: 'categories/add',
        name: 'add-category',
        component: AddCategory,
      },
      {
        path: 'categories/edit/:id',
        name: 'edit-category',
        component: EditCategory,
      },
      // User routes
      {
        path: 'users',
        name: 'user-list',
        component: AdminUserList,
      },
      {
        path: 'users/add',
        name: 'add-user',
        component: AddUser,
      },
      {
        path: 'users/edit/:id',
        name: 'edit-user',
        component: EditUser,
      },
      // Order routes
      {
        path: 'orders',
        name: 'order-list',
        component: OrderManagement,
      },
    ]
  },
  
];

// Tạo instance của router
const router = createRouter({
  history: createWebHistory(),  // Dùng Web History API
  routes,
});

export default router;
