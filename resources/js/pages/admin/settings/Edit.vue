<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Save } from 'lucide-vue-next';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{ settings: SiteSettings }>();
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Settings' },
];

const form = useForm({
    site_name: props.settings.site_name ?? '',
    tagline: props.settings.tagline ?? '',
    logo: null as File | null,
    address: props.settings.address ?? '',
    phone_1: props.settings.phone_1 ?? '',
    phone_2: props.settings.phone_2 ?? '',
    email_1: props.settings.email_1 ?? '',
    email_2: props.settings.email_2 ?? '',
    facebook_url: props.settings.facebook_url ?? '',
    youtube_url: props.settings.youtube_url ?? '',
    twitter_url: props.settings.twitter_url ?? '',
    instagram_url: props.settings.instagram_url ?? '',
    map_url: props.settings.map_url ?? '',
    map_embed_code: props.settings.map_embed_code ?? '',
});

function submit() {
    form.post('/admin/settings', {
        forceFormData: true,
        headers: { 'X-HTTP-Method-Override': 'PUT' },
    });
}
</script>

<template>
    <Head title="Site Settings" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Site Settings</h1>
                <p class="text-sm text-muted-foreground">
                    Configure your school website
                </p>
            </div>
            <form
                @submit.prevent="submit"
                class="mx-auto w-full max-w-2xl space-y-6"
            >
                <!-- General -->
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">General</h3>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >School Name</label
                        >
                        <input
                            v-model="form.site_name"
                            type="text"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                        <p
                            v-if="form.errors.site_name"
                            class="mt-1 text-xs text-destructive"
                        >
                            {{ form.errors.site_name }}
                        </p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Tagline</label
                        >
                        <input
                            v-model="form.tagline"
                            type="text"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Logo</label
                        >
                        <img
                            v-if="settings.logo"
                            :src="`/storage/${settings.logo}`"
                            class="mb-2 h-16 object-contain"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                form.logo =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                        />
                    </div>
                </div>

                <!-- Contact Info -->
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Contact Information</h3>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Address</label
                        >
                        <textarea
                            v-model="form.address"
                            rows="2"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Phone 1</label
                            >
                            <input
                                v-model="form.phone_1"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Phone 2</label
                            >
                            <input
                                v-model="form.phone_2"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Email 1</label
                            >
                            <input
                                v-model="form.email_1"
                                type="email"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Email 2</label
                            >
                            <input
                                v-model="form.email_2"
                                type="email"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Social Media</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Facebook</label
                            ><input
                                v-model="form.facebook_url"
                                type="url"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="https://"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >YouTube</label
                            ><input
                                v-model="form.youtube_url"
                                type="url"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="https://"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Twitter</label
                            ><input
                                v-model="form.twitter_url"
                                type="url"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="https://"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Instagram</label
                            ><input
                                v-model="form.instagram_url"
                                type="url"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="https://"
                            />
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Map</h3>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Map URL</label
                        >
                        <input
                            v-model="form.map_url"
                            type="url"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Map Embed Code</label
                        >
                        <textarea
                            v-model="form.map_embed_code"
                            rows="3"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 font-mono text-sm text-xs focus:ring-2 focus:ring-ring focus:outline-none"
                            placeholder="<iframe ...>"
                        />
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90 disabled:opacity-50"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save Settings' }}
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
