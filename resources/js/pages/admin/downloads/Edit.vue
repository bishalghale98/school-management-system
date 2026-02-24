<script setup lang="ts">
import type { Download, DownloadCategory } from '@/types';
import Form from './Form.vue';
defineProps<{ download: Download; categories: DownloadCategory[] }>();
</script>
<template><Form :download="download" :categories="categories" /></template>
