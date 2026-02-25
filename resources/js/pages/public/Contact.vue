<template>
    <Head title="Contact Us" />
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-teal-900 to-cyan-900 py-16 text-white"
        >
            <div class="container mx-auto px-4 text-center">
                <h1 class="mb-4 text-4xl font-bold">Contact Us</h1>
                <p class="mx-auto max-w-3xl text-xl text-teal-200">
                    Get in touch with us for any inquiries, admissions, or
                    support. We're here to help you.
                </p>
            </div>
        </section>

        <div class="container mx-auto px-4 py-16">
            <!-- Flash Messages -->
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

            <!-- Main grid: left sidebar + right form -->
            <div class="grid gap-12 lg:grid-cols-3">
                <!-- LEFT COLUMN: contact info, social, map -->
                <div class="lg:col-span-1">
                    <!-- Get in Touch card -->
                    <Card class="shadow-sm">
                        <CardHeader>
                            <CardTitle class="text-xl text-slate-800"
                                >Get in Touch</CardTitle
                            >
                        </CardHeader>
                        <CardContent class="space-y-6">
                            <!-- Address -->
                            <div
                                v-if="settings?.address"
                                class="flex items-start space-x-3"
                            >
                                <MapPin
                                    class="mt-1 h-5 w-5 shrink-0 text-slate-600"
                                />
                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        Address
                                    </h3>
                                    <p class="text-slate-600">
                                        {{ settings.address }}
                                    </p>
                                </div>
                            </div>
                            <!-- Phone -->
                            <div
                                v-if="settings?.phone_1 || settings?.phone_2"
                                class="flex items-start space-x-3"
                            >
                                <Phone
                                    class="mt-1 h-5 w-5 shrink-0 text-slate-600"
                                />
                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        Phone
                                    </h3>
                                    <p
                                        v-if="settings.phone_1"
                                        class="text-slate-600"
                                    >
                                        <a
                                            :href="`tel:${settings.phone_1}`"
                                            class="hover:text-teal-600"
                                            >{{ settings.phone_1 }}</a
                                        >
                                    </p>
                                    <p
                                        v-if="settings.phone_2"
                                        class="text-slate-600"
                                    >
                                        <a
                                            :href="`tel:${settings.phone_2}`"
                                            class="hover:text-teal-600"
                                            >{{ settings.phone_2 }}</a
                                        >
                                    </p>
                                </div>
                            </div>
                            <!-- Email -->
                            <div
                                v-if="settings?.email_1 || settings?.email_2"
                                class="flex items-start space-x-3"
                            >
                                <Mail
                                    class="mt-1 h-5 w-5 shrink-0 text-slate-600"
                                />
                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        Email
                                    </h3>
                                    <p
                                        v-if="settings.email_1"
                                        class="text-slate-600"
                                    >
                                        <a
                                            :href="`mailto:${settings.email_1}`"
                                            class="hover:text-teal-600"
                                            >{{ settings.email_1 }}</a
                                        >
                                    </p>
                                    <p
                                        v-if="settings.email_2"
                                        class="text-slate-600"
                                    >
                                        <a
                                            :href="`mailto:${settings.email_2}`"
                                            class="hover:text-teal-600"
                                            >{{ settings.email_2 }}</a
                                        >
                                    </p>
                                </div>
                            </div>
                            <!-- Office Hours (static example) -->
                            <div class="flex items-start space-x-3">
                                <Clock
                                    class="mt-1 h-5 w-5 shrink-0 text-slate-600"
                                />
                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        Office Hours
                                    </h3>
                                    <p class="text-slate-600">
                                        Sunday - Friday<br />9:00 AM - 4:00 PM
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Follow Us card (static example) -->
                    <Card class="mt-6 shadow-sm">
                        <CardHeader>
                            <CardTitle class="text-xl text-slate-800"
                                >Follow Us</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <div class="flex space-x-4">
                                <a
                                    href="#"
                                    class="rounded bg-slate-100 p-2 transition-colors hover:bg-blue-600 hover:text-white"
                                >
                                    <Facebook class="h-5 w-5" />
                                </a>
                                <a
                                    href="#"
                                    class="rounded bg-slate-100 p-2 transition-colors hover:bg-blue-400 hover:text-white"
                                >
                                    <Twitter class="h-5 w-5" />
                                </a>
                                <a
                                    href="#"
                                    class="rounded bg-slate-100 p-2 transition-colors hover:bg-red-600 hover:text-white"
                                >
                                    <Youtube class="h-5 w-5" />
                                </a>
                                <a
                                    href="#"
                                    class="rounded bg-slate-100 p-2 transition-colors hover:bg-green-600 hover:text-white"
                                >
                                    <MessageCircle class="h-5 w-5" />
                                </a>
                                <a
                                    href="#"
                                    class="rounded bg-slate-100 p-2 transition-colors hover:bg-blue-700 hover:text-white"
                                >
                                    <Linkedin class="h-5 w-5" />
                                </a>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Location / Map -->
                    <Card
                        v-if="settings?.map_embed_code"
                        class="mt-6 shadow-sm"
                    >
                        <CardHeader>
                            <CardTitle class="text-xl text-slate-800"
                                >Location</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <div
                                class="aspect-video overflow-hidden rounded-lg"
                                v-html="settings.map_embed_code"
                            />
                        </CardContent>
                    </Card>
                    <!-- Fallback map placeholder if no embed code -->
                    <Card v-else class="mt-6 shadow-sm">
                        <CardHeader>
                            <CardTitle class="text-xl text-slate-800"
                                >Location</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <div
                                class="flex h-48 w-full items-center justify-center rounded-lg bg-slate-200"
                            >
                                <div class="text-center text-slate-600">
                                    <MapPin class="mx-auto mb-2 h-8 w-8" />
                                    <p class="text-sm">Map Location</p>
                                    <p v-if="settings?.address" class="text-xs">
                                        {{ settings.address }}
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- RIGHT COLUMN: form + two info cards -->
                <div class="lg:col-span-2">
                    <!-- Main form card -->
                    <Card class="shadow-sm">
                        <CardHeader>
                            <CardTitle class="text-2xl text-slate-800"
                                >Send us a Message</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <form class="space-y-6" @submit.prevent="submit">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <Label for="name">Full Name *</Label>
                                        <Input
                                            id="name"
                                            v-model="form.name"
                                            required
                                            class="mt-1"
                                        />
                                        <p
                                            v-if="form.errors.name"
                                            class="mt-1 text-xs text-red-500"
                                        >
                                            {{ form.errors.name }}
                                        </p>
                                    </div>
                                    <div>
                                        <Label for="email"
                                            >Email Address *</Label
                                        >
                                        <Input
                                            id="email"
                                            type="email"
                                            v-model="form.email"
                                            required
                                            class="mt-1"
                                        />
                                        <p
                                            v-if="form.errors.email"
                                            class="mt-1 text-xs text-red-500"
                                        >
                                            {{ form.errors.email }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <Label for="phone">Phone Number</Label>
                                        <Input
                                            id="phone"
                                            type="tel"
                                            v-model="form.phone"
                                            class="mt-1"
                                        />
                                    </div>
                                    <div>
                                        <Label for="subject">Subject *</Label>
                                        <Input
                                            id="subject"
                                            v-model="form.subject"
                                            required
                                            class="mt-1"
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
                                    <Label for="message">Message *</Label>
                                    <Textarea
                                        id="message"
                                        v-model="form.message"
                                        required
                                        rows="6"
                                        class="mt-1"
                                        placeholder="Please describe your inquiry or message in detail..."
                                    />
                                    <p
                                        v-if="form.errors.message"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.message }}
                                    </p>
                                </div>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50"
                                >
                                    <Send
                                        v-if="!form.processing"
                                        class="mr-2 h-4 w-4"
                                    />
                                    {{
                                        form.processing
                                            ? 'Sending...'
                                            : 'Send Message'
                                    }}
                                </Button>
                            </form>
                        </CardContent>
                    </Card>

                    <!-- Two small info cards below form -->
                    <div class="mt-8 grid gap-6 md:grid-cols-2">
                        <Card class="shadow-sm">
                            <CardHeader>
                                <CardTitle class="text-lg text-slate-800"
                                    >Admission Inquiries</CardTitle
                                >
                            </CardHeader>
                            <CardContent>
                                <p class="mb-3 text-sm text-slate-600">
                                    For admission-related questions, please
                                    contact our admission office directly.
                                </p>
                                <p class="text-sm">
                                    <strong>Email:</strong>
                                    <a
                                        :href="`mailto:${settings?.email_2 || 'admission@xyz.edu.np'}`"
                                        class="text-teal-600 hover:underline"
                                    >
                                        {{
                                            settings?.email_2 ||
                                            'admission@xyz.edu.np'
                                        }} </a
                                    ><br />
                                    <strong>Phone:</strong>
                                    <a
                                        :href="`tel:${settings?.phone_1 || '+977-021-123456'}`"
                                        class="text-teal-600 hover:underline"
                                    >
                                        {{
                                            settings?.phone_1 ||
                                            '+977-021-123456'
                                        }}
                                    </a>
                                </p>
                            </CardContent>
                        </Card>

                        <Card class="shadow-sm">
                            <CardHeader>
                                <CardTitle class="text-lg text-slate-800"
                                    >General Information</CardTitle
                                >
                            </CardHeader>
                            <CardContent>
                                <p class="mb-3 text-sm text-slate-600">
                                    For general inquiries about our school
                                    programs and facilities.
                                </p>
                                <p class="text-sm">
                                    <strong>Email:</strong>
                                    <a
                                        :href="`mailto:${settings?.email_1 || 'info@xyz.edu.np'}`"
                                        class="text-teal-600 hover:underline"
                                    >
                                        {{
                                            settings?.email_1 ||
                                            'info@xyz.edu.np'
                                        }} </a
                                    ><br />
                                    <strong>Phone:</strong>
                                    <a
                                        :href="`tel:${settings?.phone_2 || '+977-021-123457'}`"
                                        class="text-teal-600 hover:underline"
                                    >
                                        {{
                                            settings?.phone_2 ||
                                            '+977-021-123457'
                                        }}
                                    </a>
                                </p>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import {
    MapPin,
    Phone,
    Mail,
    Clock,
    Send,
    CheckCircle,
    XCircle,
    Facebook,
    Twitter,
    Youtube,
    MessageCircle,
    Linkedin,
} from 'lucide-vue-next';
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SiteSettings } from '@/types';
import { Textarea } from '@/components/ui/textarea';

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
