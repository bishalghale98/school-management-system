<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { Save, ArrowLeft } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';

interface UserItem {
    id: number;
    name: string;
    email: string;
    role: 'super_admin' | 'admin' | 'editor';
}

const props = defineProps<{ user?: UserItem }>();
const isEdit = !!props.user;

const form = useForm({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    password: '',
    password_confirmation: '',
    role: props.user?.role ?? 'admin',
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Users', href: '/admin/users' },
    { title: isEdit ? 'Edit User' : 'Create User' },
];

function submit() {
    if (isEdit) {
        form.put(`/admin/users/${props.user!.id}`);
    } else {
        form.post('/admin/users');
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit User' : 'Create User'" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">
                    {{ isEdit ? 'Edit User' : 'Create User' }}
                </h1>
                <button
                    @click="router.visit('/admin/users')"
                    class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm hover:bg-accent"
                >
                    <ArrowLeft class="h-4 w-4" /> Back
                </button>
            </div>
            <form
                @submit.prevent="submit"
                class="mx-auto w-full max-w-lg space-y-6"
            >
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Name <span class="text-destructive">*</span></label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                        <p
                            v-if="form.errors.name"
                            class="mt-1 text-xs text-destructive"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Email
                            <span class="text-destructive">*</span></label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                        <p
                            v-if="form.errors.email"
                            class="mt-1 text-xs text-destructive"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Password
                            {{ isEdit ? '(leave blank to keep current)' : '' }}
                            <span v-if="!isEdit" class="text-destructive"
                                >*</span
                            ></label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                        <p
                            v-if="form.errors.password"
                            class="mt-1 text-xs text-destructive"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Confirm Password</label
                        >
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Role</label
                        >
                        <select
                            v-model="form.role"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        >
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90 disabled:opacity-50"
                    >
                        <Save class="h-4 w-4" />
                        {{
                            form.processing
                                ? 'Saving...'
                                : isEdit
                                  ? 'Update User'
                                  : 'Create User'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
