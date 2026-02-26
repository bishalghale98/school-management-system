<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Save, Plus, Trash2 } from 'lucide-vue-next';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{ settings: SiteSettings }>();
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Settings' },
];

const form = useForm({
    // General
    site_name: props.settings.site_name ?? '',
    tagline: props.settings.tagline ?? '',
    logo: null as File | null,

    // Contact
    address: props.settings.address ?? '',
    phone_1: props.settings.phone_1 ?? '',
    phone_2: props.settings.phone_2 ?? '',
    email_1: props.settings.email_1 ?? '',
    email_2: props.settings.email_2 ?? '',
    office_hours: props.settings.office_hours ?? '',

    // Social
    facebook_url: props.settings.facebook_url ?? '',
    youtube_url: props.settings.youtube_url ?? '',
    twitter_url: props.settings.twitter_url ?? '',
    instagram_url: props.settings.instagram_url ?? '',
    whatsapp_url: props.settings.whatsapp_url ?? '',
    linkedin_url: props.settings.linkedin_url ?? '',

    // Map
    map_url: props.settings.map_url ?? '',
    map_embed_code: props.settings.map_embed_code ?? '',

    // About / Overview
    established_year: props.settings.established_year ?? '',
    about_description: props.settings.about_description ?? '',
    about_quote: props.settings.about_quote ?? '',
    about_image: null as File | null,

    // Mission & Vision
    mission_title: props.settings.mission_title ?? '',
    mission_subtitle: props.settings.mission_subtitle ?? '',
    mission_description: props.settings.mission_description ?? '',
    vision_title: props.settings.vision_title ?? '',
    vision_subtitle: props.settings.vision_subtitle ?? '',
    vision_description: props.settings.vision_description ?? '',

    // Principal
    principal_name: props.settings.principal_name ?? '',
    principal_title: props.settings.principal_title ?? '',
    principal_credentials: props.settings.principal_credentials ?? '',
    principal_experience: props.settings.principal_experience ?? '',
    principal_image: null as File | null,
    principal_message: props.settings.principal_message ?? [''],

    // Stats
    stats: props.settings.stats ?? [{ value: '', label: '' }],

    // Carousel
    carousel_slides: props.settings.carousel_slides ?? [
        { image: '', title: '', description: '' },
    ],

    // Features
    features: props.settings.features ?? [
        {
            title: '',
            description: '',
            image: '',
            badge: '',
            metric: '',
            stats: '',
        },
    ],

    // Facilities
    facilities: props.settings.facilities ?? [
        { title: '', description: '', image: '' },
    ],

    // Welcome
    welcome_title: props.settings.welcome_title ?? '',
    welcome_subtitle: props.settings.welcome_subtitle ?? '',
    welcome_description: props.settings.welcome_description ?? '',
    welcome_image: null as File | null,
});

// Active section for navigation
const sections = [
    { id: 'general', label: 'General' },
    { id: 'contact', label: 'Contact' },
    { id: 'social', label: 'Social Media' },
    { id: 'map', label: 'Map' },
    { id: 'welcome', label: 'Welcome Section' },
    { id: 'carousel', label: 'Carousel' },
    { id: 'stats', label: 'Stats' },
    { id: 'features', label: 'Features' },
    { id: 'facilities', label: 'Facilities' },
    { id: 'about', label: 'About Page' },
    { id: 'mission', label: 'Mission & Vision' },
    { id: 'principal', label: 'Principal' },
];

// Dynamic array helpers
function addStat() {
    form.stats.push({ value: '', label: '' });
}
function removeStat(i: number) {
    form.stats.splice(i, 1);
}

function addSlide() {
    form.carousel_slides.push({ image: '', title: '', description: '' });
}
function removeSlide(i: number) {
    form.carousel_slides.splice(i, 1);
}

function addFeature() {
    form.features.push({
        title: '',
        description: '',
        image: '',
        badge: '',
        metric: '',
        stats: '',
    });
}
function removeFeature(i: number) {
    form.features.splice(i, 1);
}

function addFacility() {
    form.facilities.push({ title: '', description: '', image: '' });
}
function removeFacility(i: number) {
    form.facilities.splice(i, 1);
}

function addParagraph() {
    form.principal_message.push('');
}
function removeParagraph(i: number) {
    form.principal_message.splice(i, 1);
}

function submit() {
    form.post('/admin/settings', {
        forceFormData: true,
        headers: { 'X-HTTP-Method-Override': 'PUT' },
    });
}

function scrollTo(id: string) {
    document
        .getElementById(id)
        ?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

<template>
    <Head title="Site Settings" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 gap-6 p-4 md:p-6">
            <!-- Sidebar navigation -->
            <nav
                class="sticky top-20 hidden h-fit w-48 shrink-0 space-y-1 lg:block"
            >
                <button
                    v-for="s in sections"
                    :key="s.id"
                    @click="scrollTo(s.id)"
                    class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                >
                    {{ s.label }}
                </button>
            </nav>

            <!-- Form area -->
            <form
                @submit.prevent="submit"
                class="mx-auto w-full max-w-2xl space-y-6"
            >
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Site Settings
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Configure your school website content
                    </p>
                </div>

                <!-- ================================ GENERAL ================================ -->
                <div
                    id="general"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
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

                <!-- ================================ CONTACT ================================ -->
                <div
                    id="contact"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
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
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Office Hours</label
                        >
                        <input
                            v-model="form.office_hours"
                            type="text"
                            placeholder="e.g. Sun - Fri: 7:00 AM - 4:00 PM"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                </div>

                <!-- ================================ SOCIAL ================================ -->
                <div
                    id="social"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Social Media</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Facebook</label
                            >
                            <input
                                v-model="form.facebook_url"
                                type="url"
                                placeholder="https://"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >YouTube</label
                            >
                            <input
                                v-model="form.youtube_url"
                                type="url"
                                placeholder="https://"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Twitter / X</label
                            >
                            <input
                                v-model="form.twitter_url"
                                type="url"
                                placeholder="https://"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Instagram</label
                            >
                            <input
                                v-model="form.instagram_url"
                                type="url"
                                placeholder="https://"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >WhatsApp</label
                            >
                            <input
                                v-model="form.whatsapp_url"
                                type="url"
                                placeholder="https://wa.me/..."
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >LinkedIn</label
                            >
                            <input
                                v-model="form.linkedin_url"
                                type="url"
                                placeholder="https://"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- ================================ MAP ================================ -->
                <div
                    id="map"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
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
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 font-mono text-xs focus:ring-2 focus:ring-ring focus:outline-none"
                            placeholder="<iframe ...>"
                        />
                    </div>
                </div>

                <!-- ================================ WELCOME ================================ -->
                <div
                    id="welcome"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Welcome Section (Home Page)</h3>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Title</label
                        >
                        <input
                            v-model="form.welcome_title"
                            type="text"
                            placeholder="WELCOME TO OUR SCHOOL"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Subtitle</label
                        >
                        <input
                            v-model="form.welcome_subtitle"
                            type="text"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Description</label
                        >
                        <textarea
                            v-model="form.welcome_description"
                            rows="3"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Image</label
                        >
                        <img
                            v-if="settings.welcome_image"
                            :src="`/storage/${settings.welcome_image}`"
                            class="mb-2 h-32 rounded-lg object-cover"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                form.welcome_image =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                        />
                    </div>
                </div>

                <!-- ================================ CAROUSEL ================================ -->
                <div
                    id="carousel"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Hero Carousel (Home Page)</h3>
                        <button
                            type="button"
                            @click="addSlide"
                            class="inline-flex items-center gap-1 rounded-md bg-primary px-2.5 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            <Plus class="h-3.5 w-3.5" /> Add Slide
                        </button>
                    </div>
                    <div
                        v-for="(slide, i) in form.carousel_slides"
                        :key="i"
                        class="space-y-3 rounded-lg border border-dashed border-input p-4"
                    >
                        <div class="flex items-center justify-between">
                            <span
                                class="text-sm font-medium text-muted-foreground"
                                >Slide {{ i + 1 }}</span
                            >
                            <button
                                v-if="form.carousel_slides.length > 1"
                                type="button"
                                @click="removeSlide(i)"
                                class="text-destructive hover:text-destructive/80"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Image</label
                            >
                            <img
                                v-if="
                                    typeof slide.image === 'string' &&
                                    slide.image
                                "
                                :src="`/storage/${slide.image}`"
                                class="mb-2 h-24 w-full rounded-lg object-cover"
                            />
                            <input
                                type="file"
                                accept="image/*"
                                @change="
                                    slide.image =
                                        ($event.target as HTMLInputElement)
                                            .files?.[0] ?? slide.image
                                "
                                class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Title</label
                            >
                            <input
                                v-model="slide.title"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Description</label
                            >
                            <input
                                v-model="slide.description"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- ================================ STATS ================================ -->
                <div
                    id="stats"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Stats Counters</h3>
                        <button
                            type="button"
                            @click="addStat"
                            class="inline-flex items-center gap-1 rounded-md bg-primary px-2.5 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            <Plus class="h-3.5 w-3.5" /> Add Stat
                        </button>
                    </div>
                    <div
                        v-for="(stat, i) in form.stats"
                        :key="i"
                        class="flex items-end gap-3"
                    >
                        <div class="flex-1">
                            <label class="mb-1 block text-xs font-medium"
                                >Value</label
                            >
                            <input
                                v-model="stat.value"
                                type="text"
                                placeholder="25+"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div class="flex-1">
                            <label class="mb-1 block text-xs font-medium"
                                >Label</label
                            >
                            <input
                                v-model="stat.label"
                                type="text"
                                placeholder="Years of Excellence"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <button
                            v-if="form.stats.length > 1"
                            type="button"
                            @click="removeStat(i)"
                            class="mb-0.5 text-destructive hover:text-destructive/80"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <!-- ================================ FEATURES ================================ -->
                <div
                    id="features"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Features (Home Page)</h3>
                        <button
                            type="button"
                            @click="addFeature"
                            class="inline-flex items-center gap-1 rounded-md bg-primary px-2.5 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            <Plus class="h-3.5 w-3.5" /> Add Feature
                        </button>
                    </div>
                    <div
                        v-for="(feat, i) in form.features"
                        :key="i"
                        class="space-y-3 rounded-lg border border-dashed border-input p-4"
                    >
                        <div class="flex items-center justify-between">
                            <span
                                class="text-sm font-medium text-muted-foreground"
                                >Feature {{ i + 1 }}</span
                            >
                            <button
                                v-if="form.features.length > 1"
                                type="button"
                                @click="removeFeature(i)"
                                class="text-destructive hover:text-destructive/80"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs font-medium"
                                    >Title</label
                                >
                                <input
                                    v-model="feat.title"
                                    type="text"
                                    class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium"
                                    >Image URL</label
                                >
                                <input
                                    v-model="feat.image"
                                    type="text"
                                    placeholder="https://..."
                                    class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Description</label
                            >
                            <textarea
                                v-model="feat.description"
                                rows="2"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div>
                                <label class="mb-1 block text-xs font-medium"
                                    >Badge</label
                                >
                                <input
                                    v-model="feat.badge"
                                    type="text"
                                    placeholder="Top Ranked"
                                    class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium"
                                    >Metric</label
                                >
                                <input
                                    v-model="feat.metric"
                                    type="text"
                                    placeholder="5 Shields"
                                    class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium"
                                    >Stats</label
                                >
                                <input
                                    v-model="feat.stats"
                                    type="text"
                                    placeholder="National Winner"
                                    class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================================ FACILITIES ================================ -->
                <div
                    id="facilities"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Facilities (Home & About)</h3>
                        <button
                            type="button"
                            @click="addFacility"
                            class="inline-flex items-center gap-1 rounded-md bg-primary px-2.5 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            <Plus class="h-3.5 w-3.5" /> Add Facility
                        </button>
                    </div>
                    <div
                        v-for="(fac, i) in form.facilities"
                        :key="i"
                        class="space-y-3 rounded-lg border border-dashed border-input p-4"
                    >
                        <div class="flex items-center justify-between">
                            <span
                                class="text-sm font-medium text-muted-foreground"
                                >Facility {{ i + 1 }}</span
                            >
                            <button
                                v-if="form.facilities.length > 1"
                                type="button"
                                @click="removeFacility(i)"
                                class="text-destructive hover:text-destructive/80"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Title</label
                            >
                            <input
                                v-model="fac.title"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Description</label
                            >
                            <textarea
                                v-model="fac.description"
                                rows="2"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Image URL</label
                            >
                            <input
                                v-model="fac.image"
                                type="text"
                                placeholder="https://..."
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- ================================ ABOUT ================================ -->
                <div
                    id="about"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">About Page Overview</h3>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Established Year</label
                        >
                        <input
                            v-model="form.established_year"
                            type="text"
                            placeholder="Since 1998"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Quote</label
                        >
                        <textarea
                            v-model="form.about_quote"
                            rows="2"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Description</label
                        >
                        <textarea
                            v-model="form.about_description"
                            rows="3"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >About Image</label
                        >
                        <img
                            v-if="settings.about_image"
                            :src="`/storage/${settings.about_image}`"
                            class="mb-2 h-32 rounded-lg object-cover"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                form.about_image =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                        />
                    </div>
                </div>

                <!-- ================================ MISSION & VISION ================================ -->
                <div
                    id="mission"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Mission & Vision</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Mission Title</label
                            >
                            <input
                                v-model="form.mission_title"
                                type="text"
                                placeholder="Our Mission"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Mission Subtitle</label
                            >
                            <input
                                v-model="form.mission_subtitle"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Mission Description</label
                        >
                        <textarea
                            v-model="form.mission_description"
                            rows="3"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <hr class="border-input" />
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Vision Title</label
                            >
                            <input
                                v-model="form.vision_title"
                                type="text"
                                placeholder="Our Vision"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Vision Subtitle</label
                            >
                            <input
                                v-model="form.vision_subtitle"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Vision Description</label
                        >
                        <textarea
                            v-model="form.vision_description"
                            rows="3"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                </div>

                <!-- ================================ PRINCIPAL ================================ -->
                <div
                    id="principal"
                    class="scroll-mt-20 space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <h3 class="font-semibold">Principal's Message</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Name</label
                            >
                            <input
                                v-model="form.principal_name"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Title/Designation</label
                            >
                            <input
                                v-model="form.principal_title"
                                type="text"
                                placeholder="Principal"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Credentials</label
                            >
                            <input
                                v-model="form.principal_credentials"
                                type="text"
                                placeholder="M.Ed."
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium"
                                >Experience</label
                            >
                            <input
                                v-model="form.principal_experience"
                                type="text"
                                placeholder="25+ Years"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Photo</label
                        >
                        <img
                            v-if="settings.principal_image"
                            :src="`/storage/${settings.principal_image}`"
                            class="mb-2 h-32 rounded-lg object-cover"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                form.principal_image =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                        />
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium"
                                >Message Paragraphs</label
                            >
                            <button
                                type="button"
                                @click="addParagraph"
                                class="inline-flex items-center gap-1 rounded-md bg-primary px-2.5 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                            >
                                <Plus class="h-3.5 w-3.5" /> Add
                            </button>
                        </div>
                        <div
                            v-for="(_, i) in form.principal_message"
                            :key="i"
                            class="flex gap-2"
                        >
                            <textarea
                                v-model="form.principal_message[i]"
                                rows="3"
                                class="flex-1 rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                :placeholder="`Paragraph ${i + 1}`"
                            />
                            <button
                                v-if="form.principal_message.length > 1"
                                type="button"
                                @click="removeParagraph(i)"
                                class="self-start text-destructive hover:text-destructive/80"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90 disabled:opacity-50"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save All Settings' }}
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
