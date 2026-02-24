<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ArrowLeft, Trash2, Clock, Mail, Phone, User } from 'lucide-vue-next';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { ContactMessage } from '@/types';

const props = defineProps<{ message: ContactMessage }>();
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Messages', href: '/admin/messages' },
    { title: props.message.subject },
];

function formatDate(d: string) {
    return new Date(d).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
    });
}

function deleteMessage() {
    if (confirm('Delete this message?'))
        router.delete(`/admin/messages/${props.message.id}`, {
            onSuccess: () => router.visit('/admin/messages'),
        });
}
</script>

<template>
    <Head :title="`Message: ${message.subject}`" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">
                    {{ message.subject }}
                </h1>
                <div class="flex gap-2">
                    <button
                        @click="deleteMessage"
                        class="inline-flex items-center gap-2 rounded-lg border border-destructive/30 px-3 py-2 text-sm text-destructive hover:bg-destructive/10"
                    >
                        <Trash2 class="h-4 w-4" /> Delete
                    </button>
                    <button
                        @click="router.visit('/admin/messages')"
                        class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm hover:bg-accent"
                    >
                        <ArrowLeft class="h-4 w-4" /> Back
                    </button>
                </div>
            </div>
            <div class="mx-auto w-full max-w-2xl space-y-6">
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span
                            class="flex items-center gap-1.5 text-muted-foreground"
                            ><User class="h-4 w-4" /> {{ message.name }}</span
                        >
                        <span
                            v-if="message.email"
                            class="flex items-center gap-1.5 text-muted-foreground"
                            ><Mail class="h-4 w-4" /> {{ message.email }}</span
                        >
                        <span
                            v-if="message.phone"
                            class="flex items-center gap-1.5 text-muted-foreground"
                            ><Phone class="h-4 w-4" /> {{ message.phone }}</span
                        >
                        <span
                            class="flex items-center gap-1.5 text-muted-foreground"
                            ><Clock class="h-4 w-4" />
                            {{ formatDate(message.created_at) }}</span
                        >
                    </div>
                    <hr />
                    <div class="text-sm leading-relaxed whitespace-pre-wrap">
                        {{ message.message }}
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
