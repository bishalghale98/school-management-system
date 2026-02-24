<script setup lang="ts">
import type { Page } from '@/types';
import Form from './Form.vue';

defineProps<{ page: Page }>();
</script>

<template>
    <Form :page="page" />
</template>
