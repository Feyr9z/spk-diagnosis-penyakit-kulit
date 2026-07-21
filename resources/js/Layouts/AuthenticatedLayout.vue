<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import {
    Activity, LayoutDashboard, Database, ListTodo, ClipboardList,
    History, Menu, X, User, LogOut, Settings
} from 'lucide-vue-next';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingSidebar = ref(false);

const navigation = [
    { name: 'Dashboard', href: route('dashboard'), icon: LayoutDashboard, current: route().current('dashboard') },
    { name: 'Kriteria (Gejala)', href: route('gejala.index'), icon: ListTodo, current: route().current('gejala.*') },
    { name: 'Alternatif (Penyakit)', href: route('penyakit.index'), icon: Database, current: route().current('penyakit.*') },
    { name: 'Nilai Kecocokan', href: route('nilai-kecocokan.index'), icon: ClipboardList, current: route().current('nilai-kecocokan.*') },
    { name: 'Hitung SAW (Diagnosis)', href: route('diagnosis.create'), icon: Activity, current: route().current('diagnosis.*') },
    { name: 'Riwayat & Hasil', href: route('riwayat.index'), icon: History, current: route().current('riwayat.*') },
];
</script>

<template>
    <div class="min-h-screen bg-slate-900 text-slate-300 font-sans flex">
        <!-- Mobile Sidebar Backdrop -->
        <div v-show="showingSidebar" class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="showingSidebar = false"></div>

        <!-- Sidebar -->
        <div :class="[showingSidebar ? 'translate-x-0' : '-translate-x-full', 'fixed inset-y-0 left-0 z-50 w-72 bg-slate-800/50 backdrop-blur-xl border-r border-slate-700/50 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col']">
            <!-- Brand -->
            <div class="flex items-center justify-center h-20 border-b border-slate-700/50 px-6 shrink-0">
                <Link :href="route('dashboard')" class="flex items-center gap-3">
                    <Activity class="w-8 h-8 text-indigo-500" />
                    <span class="text-xl font-bold text-white tracking-tight">OptiChoice SPK</span>
                </Link>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <Link v-for="item in navigation" :key="item.name" :href="item.href"
                      :class="[item.current ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20 shadow-sm' : 'border border-transparent text-slate-400 hover:bg-slate-700/50 hover:text-white', 'group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all']">
                    <component :is="item.icon" :class="[item.current ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300', 'flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors']" />
                    <span class="truncate">{{ item.name }}</span>
                </Link>
            </nav>

            <!-- User Info (Bottom Sidebar) -->
            <div class="p-4 border-t border-slate-700/50 shrink-0">
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shrink-0">
                        {{ $page.props.auth.user.nama ? $page.props.auth.user.nama.charAt(0).toUpperCase() : 'U' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ $page.props.auth.user.nama || 'User' }}</p>
                        <p class="text-xs text-slate-400 truncate">@{{ $page.props.auth.user.username || 'user' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="h-20 bg-slate-900/50 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="showingSidebar = true" class="lg:hidden p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors">
                        <Menu class="w-6 h-6" />
                    </button>

                    <!-- Breadcrumbs/Page Title -->
                    <div v-if="$slots.header" class="hidden sm:block">
                        <slot name="header" />
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center gap-2 p-2 text-slate-400 hover:text-white transition-colors rounded-lg hover:bg-slate-800">
                                <Settings class="w-5 h-5" />
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                <div class="flex items-center gap-2">
                                    <User class="w-4 h-4" /> Profil
                                </div>
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                <div class="flex items-center gap-2 text-rose-500">
                                    <LogOut class="w-4 h-4" /> Keluar
                                </div>
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
</template>
