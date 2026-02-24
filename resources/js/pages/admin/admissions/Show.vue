<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Save,
    FileText,
    Phone,
    Mail,
    MapPin,
} from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { AdmissionApplication } from '@/types';

const props = defineProps<{ application: AdmissionApplication }>();
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Admissions', href: '/admin/admissions' },
    { title: props.application.student_name },
];

const form = useForm({
    status: props.application.status,
    admin_notes: props.application.admin_notes ?? '',
});

function submit() {
    form.put(`/admin/admissions/${props.application.id}/status`, {
        preserveScroll: true,
    });
}

function formatDate(d: string) {
    return new Date(d).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}
</script>

<template>
    <Head :title="`Application: ${application.student_name}`" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">
                    Application Details
                </h1>
                <button
                    @click="router.visit('/admin/admissions')"
                    class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm hover:bg-accent"
                >
                    <ArrowLeft class="h-4 w-4" /> Back
                </button>
            </div>
            <div class="mx-auto grid w-full max-w-3xl gap-6 lg:grid-cols-2">
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Student Information</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-muted-foreground">Student Name</dt>
                            <dd class="font-medium">
                                {{ application.student_name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-muted-foreground">Guardian Name</dt>
                            <dd class="font-medium">
                                {{ application.guardian_name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-muted-foreground">
                                Applying for Class
                            </dt>
                            <dd class="font-medium">
                                {{ application.applying_class }}
                            </dd>
                        </div>
                        <div v-if="application.previous_school">
                            <dt class="text-muted-foreground">
                                Previous School
                            </dt>
                            <dd class="font-medium">
                                {{ application.previous_school }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Contact Details</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center gap-2">
                            <Phone class="h-4 w-4 text-muted-foreground" />
                            <dd class="font-medium">{{ application.phone }}</dd>
                        </div>
                        <div
                            v-if="application.email"
                            class="flex items-center gap-2"
                        >
                            <Mail class="h-4 w-4 text-muted-foreground" />
                            <dd class="font-medium">{{ application.email }}</dd>
                        </div>
                        <div
                            v-if="application.address"
                            class="flex items-start gap-2"
                        >
                            <MapPin
                                class="mt-0.5 h-4 w-4 text-muted-foreground"
                            />
                            <dd class="font-medium">
                                {{ application.address }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-muted-foreground">Applied on</dt>
                            <dd class="font-medium">
                                {{ formatDate(application.created_at) }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div
                    v-if="application.documents?.length"
                    class="space-y-3 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm lg:col-span-2 dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Documents</h3>
                    <div class="flex flex-wrap gap-2">
                        <a
                            v-for="doc in application.documents"
                            :key="doc"
                            :href="`/storage/${doc}`"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-sm hover:bg-accent"
                        >
                            <FileText class="h-4 w-4" />
                            {{ doc.split('/').pop() }}
                        </a>
                    </div>
                </div>
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm lg:col-span-2 dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Update Status</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Status</label
                            >
                            <select
                                v-model="form.status"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            >
                                <option value="pending">Pending</option>
                                <option value="reviewed">Reviewed</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Admin Notes</label
                            >
                            <textarea
                                v-model="form.admin_notes"
                                rows="3"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="Internal notes..."
                            />
                        </div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90 disabled:opacity-50"
                        >
                            <Save class="h-4 w-4" /> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
