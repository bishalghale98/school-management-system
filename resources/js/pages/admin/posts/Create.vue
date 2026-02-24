<script setup lang="ts">
import type { PostCategory } from '@/types';

import Form from './Form.vue';

defineProps<{ categories: PostCategory[] }>();
</script>

<template>
    <Form :categories="categories" />
</template>
