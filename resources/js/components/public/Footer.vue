
<script setup>
import { computed } from 'vue'
import { 
  MapPin, 
  Phone, 
  Mail,
  Facebook,
  Twitter,
  Youtube,
  MessageCircle,
  Linkedin 
} from 'lucide-vue-next'

const currentYear = computed(() => new Date().getFullYear())

const socialLinks = [
  { 
    name: 'Facebook', 
    icon: Facebook, 
    url: '#', 
    hoverColor: 'hover:bg-blue-600' 
  },
  { 
    name: 'Twitter', 
    icon: Twitter, 
    url: '#', 
    hoverColor: 'hover:bg-blue-400' 
  },
  { 
    name: 'YouTube', 
    icon: Youtube, 
    url: '#', 
    hoverColor: 'hover:bg-red-600' 
  },
  { 
    name: 'Message', 
    icon: MessageCircle, 
    url: '#', 
    hoverColor: 'hover:bg-green-600' 
  },
  { 
    name: 'LinkedIn', 
    icon: Linkedin, 
    url: '#', 
    hoverColor: 'hover:bg-blue-700' 
  }
]

const quickLinks = [
  { text: 'News & Updates', url: '/news-update' },
  { text: 'Downloads', url: '/downloads' },
  { text: 'Gallery', url: '/gallery' },
  { text: 'Admission', url: '/admission' },
  { text: 'About Us', url: '/about' },
  { text: 'Contact Us', url: '/contact' }
]
</script>


<template>
  <footer class="border-t bg-gray-900 text-gray-300">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:grid-cols-2 lg:grid-cols-4">
      <!-- School Info -->
      <div>
        <div class="mb-4 flex items-center space-x-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-900">
              <span class="text-xs font-bold text-white">ESS</span>
            </div>
          </div>
          <h3 class="text-lg font-bold text-white">My School</h3>
        </div>
        <p class="mb-4 text-sm leading-relaxed">Excellence in Education</p>
        
        <!-- Social Icons -->
        <div class="flex space-x-4">
          <a 
            v-for="social in socialLinks" 
            :key="social.name"
            :href="social.url"
            class="rounded bg-gray-800 p-2 transition hover:bg-opacity-80"
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
            <a 
              :href="link.url" 
              class="transition hover:text-white"
            >
              {{ link.text }}
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h3 class="mb-4 text-lg font-bold text-white">Contact Us</h3>
        <ul class="space-y-3 text-sm">
          <li class="flex items-center space-x-2">
            <MapPin class="h-4 w-4 flex-shrink-0 text-gray-400" />
            <span>123 Education Street, City, State 12345</span>
          </li>
          <li class="flex items-center space-x-2">
            <Phone class="h-4 w-4 flex-shrink-0 text-gray-400" />
            <span>+1 (555) 123-4567</span>
          </li>
          <li class="flex items-center space-x-2">
            <Mail class="h-4 w-4 flex-shrink-0 text-gray-400" />
            <span>info@myschool.edu</span>
          </li>
        </ul>
      </div>

      <!-- Location -->
      <div>
        <h3 class="mb-4 text-lg font-bold text-white">Find Us</h3>
        <div class="flex items-start space-x-2">
          <MapPin class="h-4 w-4 flex-shrink-0 text-gray-400" />
          <p class="text-sm">
            Visit us at our campus.<br />
            Monday - Friday: 8:00 AM - 4:00 PM
          </p>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-gray-800 px-4 py-4 text-center text-xs text-gray-500">
      © {{ currentYear }} My School. All rights reserved.
    </div>
  </footer>
</template>
