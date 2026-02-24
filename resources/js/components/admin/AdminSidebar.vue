<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutGrid,
    FileText,
    Newspaper,
    Download,
    Image,
    GraduationCap,
    Mail,
    Settings,
    Users,
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarGroup,
    SidebarGroupLabel,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';

const { isCurrentUrl } = useCurrentUrl();
const page = usePage();
const isSuperAdmin = (page.props.auth as any)?.user?.is_super_admin;

const mainNav = [
    { title: 'Dashboard', href: '/admin', icon: LayoutGrid },
    { title: 'Pages', href: '/admin/pages', icon: FileText },
    { title: 'Posts', href: '/admin/posts', icon: Newspaper },
    { title: 'Downloads', href: '/admin/downloads', icon: Download },
    { title: 'Gallery', href: '/admin/gallery', icon: Image },
];

const managementNav = [
    { title: 'Admissions', href: '/admin/admissions', icon: GraduationCap },
    { title: 'Messages', href: '/admin/messages', icon: Mail },
    { title: 'Settings', href: '/admin/settings', icon: Settings },
];

const superAdminNav = [{ title: 'Users', href: '/admin/users', icon: Users }];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/admin">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <!-- Content Management -->
            <SidebarGroup class="px-2 py-0">
                <SidebarGroupLabel>Content</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem v-for="item in mainNav" :key="item.title">
                        <SidebarMenuButton
                            as-child
                            :is-active="isCurrentUrl(item.href)"
                            :tooltip="item.title"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>

            <!-- Management -->
            <SidebarGroup class="px-2 py-0">
                <SidebarGroupLabel>Management</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem
                        v-for="item in managementNav"
                        :key="item.title"
                    >
                        <SidebarMenuButton
                            as-child
                            :is-active="isCurrentUrl(item.href)"
                            :tooltip="item.title"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>

            <!-- Super Admin -->
            <SidebarGroup v-if="isSuperAdmin" class="px-2 py-0">
                <SidebarGroupLabel>Administration</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem
                        v-for="item in superAdminNav"
                        :key="item.title"
                    >
                        <SidebarMenuButton
                            as-child
                            :is-active="isCurrentUrl(item.href)"
                            :tooltip="item.title"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
</template>
