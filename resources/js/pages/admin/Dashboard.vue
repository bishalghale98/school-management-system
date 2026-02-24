<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    FileText,
    Newspaper,
    Image,
    Download,
    GraduationCap,
    Mail,
    ArrowRight,
    Clock,
} from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    DashboardStats,
    Post,
    AdmissionApplication,
    ContactMessage,
} from '@/types';

const props = defineProps<{
    stats: DashboardStats;
    recentPosts: Post[];
    recentApplications: AdmissionApplication[];
    recentMessages: ContactMessage[];
}>();

const breadcrumbs = [{ title: 'Dashboard', href: '/admin' }];

const statCards = [
    {
        label: 'Pages',
        value: props.stats.pages,
        icon: FileText,
        href: '/admin/pages',
        color: 'text-blue-600 bg-blue-100 dark:text-blue-400 dark:bg-blue-950',
    },
    {
        label: 'Posts',
        value: props.stats.posts,
        icon: Newspaper,
        href: '/admin/posts',
        color: 'text-emerald-600 bg-emerald-100 dark:text-emerald-400 dark:bg-emerald-950',
    },
    {
        label: 'Albums',
        value: props.stats.albums,
        icon: Image,
        href: '/admin/gallery',
        color: 'text-violet-600 bg-violet-100 dark:text-violet-400 dark:bg-violet-950',
    },
    {
        label: 'Downloads',
        value: props.stats.downloads,
        icon: Download,
        href: '/admin/downloads',
        color: 'text-amber-600 bg-amber-100 dark:text-amber-400 dark:bg-amber-950',
    },
    {
        label: 'Pending Admissions',
        value: props.stats.pendingAdmissions,
        icon: GraduationCap,
        href: '/admin/admissions',
        color: 'text-rose-600 bg-rose-100 dark:text-rose-400 dark:bg-rose-950',
    },
    {
        label: 'Unread Messages',
        value: props.stats.unreadMessages,
        icon: Mail,
        href: '/admin/messages',
        color: 'text-cyan-600 bg-cyan-100 dark:text-cyan-400 dark:bg-cyan-950',
    },
];

function formatDate(dateStr: string): string {
    return new Date(dateStr).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}

function statusBadgeClass(status: string): string {
    const map: Record<string, string> = {
        pending:
            'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
        reviewed:
            'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-200',
        accepted:
            'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200',
        rejected: 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-200',
        unread: 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
        read: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
    };
    return map[status] || 'bg-gray-100 text-gray-600';
}
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4 md:p-6">
            <!-- Stat Cards -->
            <div
                class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6"
            >
                <Link
                    v-for="stat in statCards"
                    :key="stat.label"
                    :href="stat.href"
                    class="group flex items-center gap-4 rounded-xl border border-sidebar-border/70 bg-card p-4 shadow-sm transition-all hover:border-primary/20 hover:shadow-md dark:border-sidebar-border"
                >
                    <div
                        :class="[
                            'flex h-10 w-10 shrink-0 items-center justify-center rounded-lg',
                            stat.color,
                        ]"
                    >
                        <component :is="stat.icon" class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold tracking-tight">
                            {{ stat.value }}
                        </p>
                        <p class="text-xs text-muted-foreground">
                            {{ stat.label }}
                        </p>
                    </div>
                </Link>
            </div>

            <!-- Recent Activity Grid -->
            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                <!-- Recent Posts -->
                <div
                    class="rounded-xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border"
                >
                    <div
                        class="flex items-center justify-between border-b px-5 py-4"
                    >
                        <h3 class="font-semibold">Recent Posts</h3>
                        <Link
                            href="/admin/posts"
                            class="flex items-center gap-1 text-xs text-primary hover:underline"
                        >
                            View all <ArrowRight class="h-3 w-3" />
                        </Link>
                    </div>
                    <div class="divide-y">
                        <Link
                            v-for="post in recentPosts"
                            :key="post.id"
                            :href="`/admin/posts/${post.id}/edit`"
                            class="flex items-center gap-3 px-5 py-3 transition-colors hover:bg-accent/50"
                        >
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium">
                                    {{ post.title }}
                                </p>
                                <p
                                    class="flex items-center gap-1 text-xs text-muted-foreground"
                                >
                                    <Clock class="h-3 w-3" />
                                    {{ formatDate(post.created_at) }}
                                    <span
                                        v-if="post.category"
                                        class="ml-1 text-primary/70"
                                        >· {{ post.category.name }}</span
                                    >
                                </p>
                            </div>
                            <span
                                :class="[
                                    'rounded-full px-2 py-0.5 text-[10px] font-medium',
                                    post.status === 'published'
                                        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300'
                                        : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                ]"
                            >
                                {{ post.status }}
                            </span>
                        </Link>
                        <div
                            v-if="!recentPosts.length"
                            class="px-5 py-8 text-center text-sm text-muted-foreground"
                        >
                            No posts yet
                        </div>
                    </div>
                </div>

                <!-- Recent Applications -->
                <div
                    class="rounded-xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border"
                >
                    <div
                        class="flex items-center justify-between border-b px-5 py-4"
                    >
                        <h3 class="font-semibold">Recent Applications</h3>
                        <Link
                            href="/admin/admissions"
                            class="flex items-center gap-1 text-xs text-primary hover:underline"
                        >
                            View all <ArrowRight class="h-3 w-3" />
                        </Link>
                    </div>
                    <div class="divide-y">
                        <Link
                            v-for="app in recentApplications"
                            :key="app.id"
                            :href="`/admin/admissions/${app.id}`"
                            class="flex items-center gap-3 px-5 py-3 transition-colors hover:bg-accent/50"
                        >
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium">
                                    {{ app.student_name }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    Class {{ app.applying_class }} ·
                                    {{ formatDate(app.created_at) }}
                                </p>
                            </div>
                            <span
                                :class="[
                                    'rounded-full px-2 py-0.5 text-[10px] font-medium capitalize',
                                    statusBadgeClass(app.status),
                                ]"
                            >
                                {{ app.status }}
                            </span>
                        </Link>
                        <div
                            v-if="!recentApplications.length"
                            class="px-5 py-8 text-center text-sm text-muted-foreground"
                        >
                            No applications yet
                        </div>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div
                    class="rounded-xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border"
                >
                    <div
                        class="flex items-center justify-between border-b px-5 py-4"
                    >
                        <h3 class="font-semibold">Recent Messages</h3>
                        <Link
                            href="/admin/messages"
                            class="flex items-center gap-1 text-xs text-primary hover:underline"
                        >
                            View all <ArrowRight class="h-3 w-3" />
                        </Link>
                    </div>
                    <div class="divide-y">
                        <Link
                            v-for="msg in recentMessages"
                            :key="msg.id"
                            :href="`/admin/messages/${msg.id}`"
                            class="flex items-center gap-3 px-5 py-3 transition-colors hover:bg-accent/50"
                        >
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium">
                                    {{ msg.subject }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ msg.name }} ·
                                    {{ formatDate(msg.created_at) }}
                                </p>
                            </div>
                            <span
                                :class="[
                                    'rounded-full px-2 py-0.5 text-[10px] font-medium capitalize',
                                    statusBadgeClass(msg.status),
                                ]"
                            >
                                {{ msg.status }}
                            </span>
                        </Link>
                        <div
                            v-if="!recentMessages.length"
                            class="px-5 py-8 text-center text-sm text-muted-foreground"
                        >
                            No messages yet
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
