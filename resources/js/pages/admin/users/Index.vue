<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Plus,
    Pencil,
    Trash2,
    Shield,
    ShieldCheck,
    ShieldAlert,
} from 'lucide-vue-next';
import Pagination from '@/components/admin/Pagination.vue';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { PaginatedData } from '@/types';

interface UserItem {
    id: number;
    name: string;
    email: string;
    role: 'super_admin' | 'admin' | 'editor';
    created_at: string;
}

defineProps<{ users: PaginatedData<UserItem> }>();
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Users' },
];

function deleteUser(user: UserItem) {
    if (confirm(`Delete "${user.name}"?`))
        router.delete(`/admin/users/${user.id}`);
}

function roleIcon(role: string) {
    if (role === 'super_admin') return ShieldAlert;
    if (role === 'admin') return ShieldCheck;
    return Shield;
}

function roleClass(role: string) {
    if (role === 'super_admin')
        return 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300';
    if (role === 'admin')
        return 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300';
    return 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400';
}
</script>

<template>
    <Head title="Manage Users" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Users</h1>
                    <p class="text-sm text-muted-foreground">
                        Manage admin users
                    </p>
                </div>
                <Link
                    href="/admin/users/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" /> Add User
                </Link>
            </div>
            <div
                class="rounded-xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-muted/30">
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Name
                                </th>
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Email
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Role
                                </th>
                                <th
                                    class="px-4 py-3 text-right font-medium text-muted-foreground"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr
                                v-for="user in users.data"
                                :key="user.id"
                                class="hover:bg-accent/30"
                            >
                                <td class="px-4 py-3 font-medium">
                                    {{ user.name }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ user.email }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        :class="[
                                            'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium',
                                            roleClass(user.role),
                                        ]"
                                    >
                                        <component
                                            :is="roleIcon(user.role)"
                                            class="h-3 w-3"
                                        />
                                        {{ user.role.replace('_', ' ') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-1"
                                    >
                                        <Link
                                            :href="`/admin/users/${user.id}/edit`"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-accent hover:text-foreground"
                                            ><Pencil class="h-4 w-4"
                                        /></Link>
                                        <button
                                            @click="deleteUser(user)"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!users.data.length">
                                <td
                                    colspan="4"
                                    class="px-4 py-12 text-center text-muted-foreground"
                                >
                                    No users found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="users" />
            </div>
        </div>
    </AdminLayout>
</template>
