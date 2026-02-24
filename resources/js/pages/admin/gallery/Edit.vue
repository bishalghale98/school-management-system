<script setup lang="ts">
import type { GalleryAlbum } from '@/types';
import Form from './Form.vue';
defineProps<{ album: GalleryAlbum }>();
</script>
<template><Form :album="album" /></template>
