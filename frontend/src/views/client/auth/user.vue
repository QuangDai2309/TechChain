<template>
    <div v-if="user">
        <h2>Xin chào, {{ user.name }}!</h2>
        <p>Email: {{ user.email }}</p>
        <button @click="logout" class="btn btn-danger">Đăng xuất</button>

    </div>
    <div v-else>
        <p>Không có thông tin người dùng.</p>
    </div>
</template>

<script>
import { isLoggedIn, getUser } from '@/store/auth.js';
import axios from 'axios';
export default {
    data() {
        return {
            user: null
        };
    },
    mounted() {
        if (!isLoggedIn()) {
            this.$router.push('/login');
        } else {
            this.user = getUser();
        }
    },
    methods: {
        async logout() {
            try {
                // Xoá thông tin user khỏi sessionStorage
                sessionStorage.removeItem('user');

                // Chuyển về trang login
                this.$router.push('/login');
            } catch (err) {
                console.error('Lỗi đăng xuất:', err);
            }
        }
    }
};
</script>