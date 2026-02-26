<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Footer from '@/components/public/Footer.vue';

import Navbar from '@/Components/Public/Navbar.vue';
import type { SiteSettings } from '@/types';

const page = usePage();
const settings = computed(() => page.props.siteSettings as SiteSettings);
</script>

<template>
    <Navbar :settings="settings" />

    <main class="min-h-[60vh]">
        <slot />
    </main>

    <Footer :settings="settings" />
</template>
