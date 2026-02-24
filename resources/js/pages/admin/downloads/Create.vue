<script setup lang="ts">
import type { DownloadCategory } from '@/types';
import Form from './Form.vue';
defineProps<{ categories: DownloadCategory[] }>();
</script>
<template><Form :categories="categories" /></template>
