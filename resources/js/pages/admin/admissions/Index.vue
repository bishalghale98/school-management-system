<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, ToggleLeft, ToggleRight } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Pagination from '@/components/admin/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    AdmissionApplication,
    AdmissionSetting,
    PaginatedData,
} from '@/types';

const props = defineProps<{
    applications: PaginatedData<AdmissionApplication>;
    admissionSettings: AdmissionSetting;
    filters: { status?: string };
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Admissions' },
];
const status = ref(props.filters.status ?? '');

watch(status, () => {
    router.get(
        '/admin/admissions',
        { status: status.value || undefined },
        { preserveState: true, replace: true },
    );
});

function toggleAdmission() {
    router.post('/admin/admissions/toggle', {}, { preserveScroll: true });
}

function formatDate(d: string) {
    return new Date(d).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}

function statusClass(s: string) {
    const m: Record<string, string> = {
        pending:
            'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
        reviewed:
            'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
        accepted:
            'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
        rejected: 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
    };
    return m[s] || '';
}
</script>

<template>
    <Head title="Manage Admissions" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Admissions
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Manage admission applications
                    </p>
                </div>
                <button
                    @click="toggleAdmission"
                    :class="[
                        'inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium shadow-sm transition-colors',
                        admissionSettings.is_open
                            ? 'bg-emerald-600 text-white hover:bg-emerald-700'
                            : 'bg-gray-600 text-white hover:bg-gray-700',
                    ]"
                >
                    <ToggleRight
                        v-if="admissionSettings.is_open"
                        class="h-4 w-4"
                    />
                    <ToggleLeft v-else class="h-4 w-4" />
                    {{
                        admissionSettings.is_open
                            ? 'Admission Open'
                            : 'Admission Closed'
                    }}
                </button>
            </div>
            <div class="flex gap-3">
                <select
                    v-model="status"
                    class="rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                >
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </select>
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
                                    Student
                                </th>
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Guardian
                                </th>
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Class
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Date
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
                                v-for="app in applications.data"
                                :key="app.id"
                                class="hover:bg-accent/30"
                            >
                                <td class="px-4 py-3 font-medium">
                                    {{ app.student_name }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ app.guardian_name }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ app.applying_class }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        :class="[
                                            'inline-flex rounded-full px-2 py-0.5 text-xs font-medium capitalize',
                                            statusClass(app.status),
                                        ]"
                                        >{{ app.status }}</span
                                    >
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ formatDate(app.created_at) }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <Link
                                        :href="`/admin/admissions/${app.id}`"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-accent hover:text-foreground"
                                        ><Eye class="h-4 w-4"
                                    /></Link>
                                </td>
                            </tr>
                            <tr v-if="!applications.data.length">
                                <td
                                    colspan="6"
                                    class="px-4 py-12 text-center text-muted-foreground"
                                >
                                    No applications found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="applications" />
            </div>
        </div>
    </AdminLayout>
</template>
