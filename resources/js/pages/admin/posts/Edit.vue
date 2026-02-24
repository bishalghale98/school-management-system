<script setup lang="ts">
import type { Post, PostCategory } from '@/types';
import Form from './Form.vue';

defineProps<{ post: Post; categories: PostCategory[] }>();
</script>

<template>
    <Form :post="post" :categories="categories" />
</template>
