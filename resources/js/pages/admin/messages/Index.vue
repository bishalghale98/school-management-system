<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Trash2, MailOpen, Mail as MailIcon } from 'lucide-vue-next';

import { ref, watch } from 'vue';
import Pagination from '@/components/admin/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { ContactMessage, PaginatedData } from '@/types';

const props = defineProps<{
    messages: PaginatedData<ContactMessage>;
    filters: { status?: string };
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Messages' },
];
const status = ref(props.filters.status ?? '');

watch(status, () => {
    router.get(
        '/admin/messages',
        { status: status.value || undefined },
        { preserveState: true, replace: true },
    );
});

function deleteMessage(msg: ContactMessage) {
    if (confirm('Delete this message?'))
        router.delete(`/admin/messages/${msg.id}`);
}

function formatDate(d: string) {
    return new Date(d).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}
</script>

<template>
    <Head title="Contact Messages" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Messages</h1>
                <p class="text-sm text-muted-foreground">
                    View contact form submissions
                </p>
            </div>
            <div class="flex gap-3">
                <select
                    v-model="status"
                    class="rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                >
                    <option value="">All</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                </select>
            </div>
            <div
                class="rounded-xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border"
            >
                <div class="divide-y">
                    <Link
                        v-for="msg in messages.data"
                        :key="msg.id"
                        :href="`/admin/messages/${msg.id}`"
                        :class="[
                            'flex items-center gap-4 px-5 py-4 transition-colors hover:bg-accent/30',
                            msg.status === 'unread' ? 'bg-primary/5' : '',
                        ]"
                    >
                        <div
                            :class="[
                                'flex h-8 w-8 shrink-0 items-center justify-center rounded-full',
                                msg.status === 'unread'
                                    ? 'bg-amber-100 text-amber-600 dark:bg-amber-950 dark:text-amber-400'
                                    : 'bg-muted text-muted-foreground',
                            ]"
                        >
                            <MailIcon
                                v-if="msg.status === 'unread'"
                                class="h-4 w-4"
                            />
                            <MailOpen v-else class="h-4 w-4" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p
                                :class="[
                                    'text-sm',
                                    msg.status === 'unread'
                                        ? 'font-semibold'
                                        : 'font-medium',
                                ]"
                            >
                                {{ msg.subject }}
                            </p>
                            <p class="truncate text-xs text-muted-foreground">
                                {{ msg.name }}
                                {{ msg.email ? `· ${msg.email}` : '' }}
                            </p>
                        </div>
                        <span class="shrink-0 text-xs text-muted-foreground">{{
                            formatDate(msg.created_at)
                        }}</span>
                        <button
                            @click.prevent="deleteMessage(msg)"
                            class="shrink-0 rounded-md p-1.5 text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </Link>
                    <div
                        v-if="!messages.data.length"
                        class="px-5 py-12 text-center text-muted-foreground"
                    >
                        No messages found.
                    </div>
                </div>
                <Pagination :data="messages" />
            </div>
        </div>
    </AdminLayout>
</template>
