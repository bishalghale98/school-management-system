<script setup lang="ts">
import {
    MapPin,
    Phone,
    Mail,
    Facebook,
    Twitter,
    Youtube,
    MessageCircle,
    Linkedin,
} from 'lucide-vue-next';
import { computed } from 'vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{
    settings: SiteSettings;
}>();

const currentYear = computed(() => new Date().getFullYear());

const socialLinks = computed(() => {
    const links = [];
    if (props.settings?.facebook_url)
        links.push({
            name: 'Facebook',
            icon: Facebook,
            url: props.settings.facebook_url,
            hoverColor: 'hover:bg-blue-600',
        });
    if (props.settings?.twitter_url)
        links.push({
            name: 'Twitter',
            icon: Twitter,
            url: props.settings.twitter_url,
            hoverColor: 'hover:bg-blue-400',
        });
    if (props.settings?.youtube_url)
        links.push({
            name: 'YouTube',
            icon: Youtube,
            url: props.settings.youtube_url,
            hoverColor: 'hover:bg-red-600',
        });
    if (props.settings?.whatsapp_url)
        links.push({
            name: 'WhatsApp',
            icon: MessageCircle,
            url: props.settings.whatsapp_url,
            hoverColor: 'hover:bg-green-600',
        });
    if (props.settings?.linkedin_url)
        links.push({
            name: 'LinkedIn',
            icon: Linkedin,
            url: props.settings.linkedin_url,
            hoverColor: 'hover:bg-blue-700',
        });
    return links;
});

const quickLinks = [
    { text: 'News & Updates', url: '/news-update' },
    { text: 'Downloads', url: '/downloads' },
    { text: 'Gallery', url: '/gallery' },
    { text: 'Admission', url: '/admission' },
    { text: 'About Us', url: '/about' },
    { text: 'Contact Us', url: '/contact-us' },
];
</script>

<template>
    <footer class="border-t bg-gray-900 text-gray-300">
        <div
            class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:grid-cols-2 lg:grid-cols-4"
        >
            <!-- School Info -->
            <div>
                <div class="mb-4 flex items-center space-x-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white"
                    >
                        <img
                            v-if="settings?.logo"
                            :src="`/storage/${settings.logo}`"
                            :alt="settings?.site_name"
                            class="h-8 w-8 rounded-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-900"
                        >
                            <span class="text-xs font-bold text-white"
                                >LOGO</span
                            >
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white">
                        {{ settings?.site_name ?? 'My School' }}
                    </h3>
                </div>
                <p class="mb-4 text-sm leading-relaxed">
                    {{ settings?.tagline ?? 'Excellence in Education' }}
                </p>

                <!-- Social Icons -->
                <div v-if="socialLinks.length" class="flex space-x-4">
                    <a
                        v-for="social in socialLinks"
                        :key="social.name"
                        :href="social.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:bg-opacity-80 rounded bg-gray-800 p-2 transition"
                        :class="social.hoverColor"
                        :aria-label="social.name"
                    >
                        <component :is="social.icon" class="h-5 w-5" />
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li v-for="link in quickLinks" :key="link.text">
                        <a :href="link.url" class="transition hover:text-white">
                            {{ link.text }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">Contact Us</h3>
                <ul class="space-y-3 text-sm">
                    <li
                        v-if="settings?.address"
                        class="flex items-center space-x-2"
                    >
                        <MapPin class="h-4 w-4 flex-shrink-0 text-gray-400" />
                        <span>{{ settings.address }}</span>
                    </li>
                    <li
                        v-if="settings?.phone_1"
                        class="flex items-center space-x-2"
                    >
                        <Phone class="h-4 w-4 flex-shrink-0 text-gray-400" />
                        <a
                            :href="`tel:${settings.phone_1}`"
                            class="transition hover:text-white"
                        >
                            {{ settings.phone_1 }}
                        </a>
                    </li>
                    <li
                        v-if="settings?.phone_2"
                        class="flex items-center space-x-2"
                    >
                        <Phone class="h-4 w-4 flex-shrink-0 text-gray-400" />
                        <a
                            :href="`tel:${settings.phone_2}`"
                            class="transition hover:text-white"
                        >
                            {{ settings.phone_2 }}
                        </a>
                    </li>
                    <li
                        v-if="settings?.email_1"
                        class="flex items-center space-x-2"
                    >
                        <Mail class="h-4 w-4 flex-shrink-0 text-gray-400" />
                        <a
                            :href="`mailto:${settings.email_1}`"
                            class="transition hover:text-white"
                        >
                            {{ settings.email_1 }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Location -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">Find Us</h3>
                <div class="flex items-start space-x-2">
                    <MapPin class="h-4 w-4 flex-shrink-0 text-gray-400" />
                    <p class="text-sm">
                        <span v-if="settings?.address">
                            {{ settings.address }}<br />
                        </span>
                        {{
                            settings?.office_hours ??
                            'Sunday - Friday: 8:00 AM - 4:00 PM'
                        }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div
            class="border-t border-gray-800 px-4 py-4 text-center text-xs text-gray-500"
        >
            © {{ currentYear }} {{ settings?.site_name ?? 'My School' }}. All
            rights reserved.
        </div>
    </footer>
</template>
