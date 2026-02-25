<script setup>
import { ref } from 'vue'
import {
  Facebook,
  Twitter,
  Youtube,
  MessageCircle,
  Linkedin,
  Menu,
  ChevronDown,
} from 'lucide-vue-next'

// Props for customization
defineProps({
  schoolName: {
    type: String,
    default: 'SCHOOL Name',
  },
  schoolAddress: {
    type: String,
    default: 'School Name Address',
  },
})

// Mobile menu state
const isMobileMenuOpen = ref(false)
const openDropdown = ref(null)
const openMobileDropdown = ref(null)

// Social media icons
const socialIcons = [
  { name: 'Facebook', icon: Facebook, url: '#', color: 'text-blue-400' },
  { name: 'Twitter', icon: Twitter, url: '#', color: 'text-blue-400' },
  { name: 'YouTube', icon: Youtube, url: '#', color: 'text-red-500' },
  { name: 'Message', icon: MessageCircle, url: '#', color: 'text-green-500' },
  { name: 'LinkedIn', icon: Linkedin, url: '#', color: 'text-blue-600' },
]

// Navigation items
const navItems = [
  { text: 'Home', url: '/' },
  {
    text: 'About Us',
    children: [
      { text: 'Our Story', url: '/about/story' },
      { text: 'Mission & Vision', url: '/about/mission' },
      { text: 'Faculty', url: '/about/faculty' },
      { text: 'Facilities', url: '/about/facilities' },
    ],
  },
  { text: 'Downloads', url: '/downloads' },
  { text: 'Gallery', url: '/gallery' },
  { text: 'News Update', url: '/news' },
  { text: 'Admission Form', url: '/admission' },
]

// Methods
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
  openMobileDropdown.value = null
}

const toggleMobileDropdown = (itemText) => {
  openMobileDropdown.value =
    openMobileDropdown.value === itemText ? null : itemText
}

// Close mobile menu when clicking outside (optional - you can add this)
// You might want to add a click-outside directive here
</script>

<style scoped>
/* Optional: Add smooth scrolling for the mobile menu */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

<template>
    <header class="sticky top-0 z-50 bg-slate-800 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <!-- Top bar with social icons -->
            <div class="flex justify-end border-b border-slate-700 py-2">
                <div class="flex space-x-2">
                    <a
                        v-for="social in socialIcons"
                        :key="social.name"
                        :href="social.url"
                        class="rounded p-1 hover:bg-slate-700"
                        :aria-label="social.name"
                    >
                        <component
                            :is="social.icon"
                            class="h-4 w-4"
                            :class="social.color"
                        />
                    </a>
                </div>
            </div>

            <!-- Main header -->
            <div class="flex items-center justify-between py-4">
                <!-- Logo and school name -->
                <div class="flex items-center space-x-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-white"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800"
                        >
                            <span class="text-xs font-bold text-white"
                                >LOGO</span
                            >
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">{{ schoolName }}</h1>
                        <p class="text-sm text-slate-300">
                            {{ schoolAddress }}
                        </p>
                    </div>
                </div>

                <!-- Desktop Navigation (hidden on mobile) -->
                <nav
                    class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-center"
                >
                    <ul class="flex space-x-1">
                        <li v-for="item in navItems" :key="item.text">
                            <!-- Dropdown menu for items with children -->
                            <div
                                v-if="item.children"
                                class="relative"
                                @mouseenter="openDropdown = item.text"
                                @mouseleave="openDropdown = null"
                            >
                                <button
                                    class="group inline-flex h-10 w-max items-center justify-center rounded px-4 py-2 text-sm font-medium hover:bg-slate-700"
                                    :class="{
                                        'bg-slate-700':
                                            openDropdown === item.text,
                                    }"
                                >
                                    {{ item.text }}
                                    <ChevronDown
                                        class="relative top-[1px] ml-1 h-3 w-3 transition duration-200"
                                        :class="{
                                            'rotate-180':
                                                openDropdown === item.text,
                                        }"
                                    />
                                </button>

                                <!-- Dropdown content -->
                                <div
                                    v-if="openDropdown === item.text"
                                    class="absolute top-full left-0 mt-1 w-48 rounded-md bg-slate-700 py-1 shadow-lg"
                                >
                                    <a
                                        v-for="child in item.children"
                                        :key="child.text"
                                        :href="child.url"
                                        class="block px-4 py-2 text-sm hover:bg-slate-600"
                                    >
                                        {{ child.text }}
                                    </a>
                                </div>
                            </div>

                            <!-- Regular link -->
                            <a
                                v-else
                                :href="item.url"
                                class="inline-block rounded px-4 py-2 text-sm font-medium hover:bg-slate-700"
                            >
                                {{ item.text }}
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Contact Us button (desktop) -->
                <a
                    href="/contact"
                    class="hidden items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-700 lg:flex"
                >
                    Contact Us
                </a>

                <!-- Mobile menu button -->
                <button
                    class="inline-flex h-10 w-10 items-center justify-center rounded-md hover:bg-slate-700 lg:hidden"
                    type="button"
                    @click="toggleMobileMenu"
                >
                    <Menu class="h-6 w-6" />
                </button>
            </div>

            <!-- Mobile Menu (slide-down) -->
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="transform -translate-y-2 opacity-0"
                enter-to-class="transform translate-y-0 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="transform translate-y-0 opacity-100"
                leave-to-class="transform -translate-y-2 opacity-0"
            >
                <div
                    v-if="isMobileMenuOpen"
                    class="border-t border-slate-700 py-4 lg:hidden"
                >
                    <nav class="flex flex-col space-y-2">
                        <!-- Mobile navigation items -->
                        <template v-for="item in navItems" :key="item.text">
                            <!-- Mobile dropdown trigger -->
                            <div v-if="item.children" class="flex flex-col">
                                <button
                                    class="flex items-center justify-between rounded px-4 py-2 text-left hover:bg-slate-700"
                                    @click="toggleMobileDropdown(item.text)"
                                >
                                    <span>{{ item.text }}</span>
                                    <ChevronDown
                                        class="h-4 w-4 transition duration-200"
                                        :class="{
                                            'rotate-180':
                                                openMobileDropdown ===
                                                item.text,
                                        }"
                                    />
                                </button>

                                <!-- Mobile dropdown items -->
                                <Transition
                                    enter-active-class="transition duration-200 ease-out"
                                    enter-from-class="transform -translate-y-2 opacity-0"
                                    enter-to-class="transform translate-y-0 opacity-100"
                                    leave-active-class="transition duration-150 ease-in"
                                    leave-from-class="transform translate-y-0 opacity-100"
                                    leave-to-class="transform -translate-y-2 opacity-0"
                                >
                                    <div
                                        v-if="openMobileDropdown === item.text"
                                        class="mt-1 ml-4 flex flex-col space-y-1"
                                    >
                                        <a
                                            v-for="child in item.children"
                                            :key="child.text"
                                            :href="child.url"
                                            class="rounded px-4 py-2 text-sm hover:bg-slate-700"
                                            @click="closeMobileMenu"
                                        >
                                            {{ child.text }}
                                        </a>
                                    </div>
                                </Transition>
                            </div>

                            <!-- Mobile regular link -->
                            <a
                                v-else
                                :href="item.url"
                                class="rounded px-4 py-2 hover:bg-slate-700"
                                @click="closeMobileMenu"
                            >
                                {{ item.text }}
                            </a>
                        </template>

                        <!-- Mobile contact button -->
                        <a
                            href="/contact"
                            class="mt-2 rounded-md bg-green-600 px-4 py-2 text-center font-medium hover:bg-green-700"
                            @click="closeMobileMenu"
                        >
                            Contact Us
                        </a>
                    </nav>
                </div>
            </Transition>
        </div>
    </header>
</template>
