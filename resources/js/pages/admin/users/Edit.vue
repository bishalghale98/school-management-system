<script setup lang="ts">
import Form from './Form.vue';

interface UserItem {
    id: number;
    name: string;
    email: string;
    role: 'super_admin' | 'admin' | 'editor';
}

defineProps<{ user: UserItem }>();
</script>
<template><Form :user="user" /></template>
