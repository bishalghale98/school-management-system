<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import {
    MapPin,
    Phone,
    Mail,
    Send,
    CheckCircle,
    XCircle,
} from 'lucide-vue-next';
import { computed } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SiteSettings } from '@/types';

defineProps<{
    settings: SiteSettings;
}>();

const page = usePage();
const flash = computed(
    () => page.props.flash as { success?: string; error?: string },
);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
});

function submit() {
    form.post('/contact-us', {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Contact Us" />
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-teal-900 to-cyan-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <h1 class="text-3xl font-bold sm:text-4xl">Contact Us</h1>
                <p class="mt-2 text-teal-200">We'd love to hear from you</p>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-10">
            <!-- Flash -->
            <div
                v-if="flash.success"
                class="mb-6 flex items-center gap-3 rounded-xl bg-green-50 p-4 text-green-700 ring-1 ring-green-200"
            >
                <CheckCircle class="h-5 w-5 shrink-0" />
                <p class="text-sm font-medium">{{ flash.success }}</p>
            </div>
            <div
                v-if="flash.error"
                class="mb-6 flex items-center gap-3 rounded-xl bg-red-50 p-4 text-red-700 ring-1 ring-red-200"
            >
                <XCircle class="h-5 w-5 shrink-0" />
                <p class="text-sm font-medium">{{ flash.error }}</p>
            </div>

            <div class="grid gap-8 lg:grid-cols-5">
                <!-- Contact Info -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <div v-if="settings?.address" class="flex gap-4">
                            <div
                                class="shrink-0 rounded-lg bg-teal-100 p-3 text-teal-600"
                            >
                                <MapPin class="h-5 w-5" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    Address
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ settings.address }}
                                </p>
                            </div>
                        </div>
                        <div
                            v-if="settings?.phone_1 || settings?.phone_2"
                            class="flex gap-4"
                        >
                            <div
                                class="shrink-0 rounded-lg bg-teal-100 p-3 text-teal-600"
                            >
                                <Phone class="h-5 w-5" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    Phone
                                </h3>
                                <p
                                    v-if="settings.phone_1"
                                    class="mt-1 text-sm text-gray-500"
                                >
                                    <a
                                        :href="`tel:${settings.phone_1}`"
                                        class="hover:text-teal-600"
                                        >{{ settings.phone_1 }}</a
                                    >
                                </p>
                                <p
                                    v-if="settings.phone_2"
                                    class="text-sm text-gray-500"
                                >
                                    <a
                                        :href="`tel:${settings.phone_2}`"
                                        class="hover:text-teal-600"
                                        >{{ settings.phone_2 }}</a
                                    >
                                </p>
                            </div>
                        </div>
                        <div
                            v-if="settings?.email_1 || settings?.email_2"
                            class="flex gap-4"
                        >
                            <div
                                class="shrink-0 rounded-lg bg-teal-100 p-3 text-teal-600"
                            >
                                <Mail class="h-5 w-5" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    Email
                                </h3>
                                <p
                                    v-if="settings.email_1"
                                    class="mt-1 text-sm text-gray-500"
                                >
                                    <a
                                        :href="`mailto:${settings.email_1}`"
                                        class="hover:text-teal-600"
                                        >{{ settings.email_1 }}</a
                                    >
                                </p>
                                <p
                                    v-if="settings.email_2"
                                    class="text-sm text-gray-500"
                                >
                                    <a
                                        :href="`mailto:${settings.email_2}`"
                                        class="hover:text-teal-600"
                                        >{{ settings.email_2 }}</a
                                    >
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div
                        v-if="settings?.map_embed_code"
                        class="mt-8 aspect-video overflow-hidden rounded-xl shadow-sm ring-1 ring-gray-200"
                        v-html="settings.map_embed_code"
                    />
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-3">
                    <div
                        class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100"
                    >
                        <h2 class="mb-6 text-xl font-bold text-gray-900">
                            Send us a Message
                        </h2>
                        <form @submit.prevent="submit" class="space-y-5">
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700"
                                        >Your Name *</label
                                    >
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 focus:outline-none"
                                    />
                                    <p
                                        v-if="form.errors.name"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.name }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700"
                                        >Email</label
                                    >
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 focus:outline-none"
                                    />
                                    <p
                                        v-if="form.errors.email"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700"
                                        >Phone</label
                                    >
                                    <input
                                        v-model="form.phone"
                                        type="tel"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 focus:outline-none"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700"
                                        >Subject *</label
                                    >
                                    <input
                                        v-model="form.subject"
                                        type="text"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 focus:outline-none"
                                    />
                                    <p
                                        v-if="form.errors.subject"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.subject }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Message *</label
                                >
                                <textarea
                                    v-model="form.message"
                                    rows="5"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 focus:outline-none"
                                />
                                <p
                                    v-if="form.errors.message"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors.message }}
                                </p>
                            </div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700 disabled:opacity-50"
                            >
                                <Send class="h-4 w-4" />
                                {{
                                    form.processing
                                        ? 'Sending...'
                                        : 'Send Message'
                                }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
