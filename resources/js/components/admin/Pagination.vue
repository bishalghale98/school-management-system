<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { PaginatedData } from '@/types';

const props = defineProps<{
    data: PaginatedData<any>;
}>();
</script>

<template>
    <div
        v-if="data.last_page > 1"
        class="flex items-center justify-between px-2 py-3"
    >
        <p class="text-sm text-muted-foreground">
            Showing {{ data.from }} to {{ data.to }} of {{ data.total }} results
        </p>
        <div class="flex items-center gap-1">
            <template v-for="link in data.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    :class="[
                        'inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm transition-colors',
                        link.active
                            ? 'bg-primary text-primary-foreground'
                            : 'hover:bg-accent hover:text-accent-foreground',
                    ]"
                    v-html="link.label"
                    preserve-scroll
                />
                <span
                    v-else
                    class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm text-muted-foreground opacity-50"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
