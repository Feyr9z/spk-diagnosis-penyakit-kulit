<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Users, Plus, Trash2, Shield, User, AlertTriangle } from 'lucide-vue-next';

defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const page = usePage();
const currentUserId = computed(() => page.props.auth.user.id);

const confirmingUserDeletion = ref(null);

const confirmUserDeletion = (user) => {
    confirmingUserDeletion.value = user;
};

const cancelUserDeletion = () => {
    confirmingUserDeletion.value = null;
};

const deleteUser = (id) => {
    router.delete(route('users.destroy', id), {
        preserveScroll: true,
        onSuccess: () => cancelUserDeletion(),
    });
};
</script>

<template>
    <Head title="Manajemen User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                <Users class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                Manajemen User
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Kelola daftar pengguna dan hak akses aplikasi.
                </p>
                
                <Link
                    :href="route('users.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all"
                >
                    <Plus class="w-4 h-4" /> Tambah User
                </Link>
            </div>

            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/80 dark:divide-slate-700/50">
                        <thead class="bg-slate-100/80 dark:bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Username</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Role</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 w-36">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200/80 dark:divide-slate-700/50 bg-transparent">
                            <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 dark:text-white">{{ user.nama }}</span>
                                        <!-- Self badge -->
                                        <span v-if="user.id === currentUserId" class="text-[10px] font-extrabold uppercase tracking-wider px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-600">
                                            Anda
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                    {{ user.username }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-xs font-bold"
                                        :class="user.role === 'super_admin' ? 'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20' : 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20'">
                                        <Shield v-if="user.role === 'super_admin'" class="w-3.5 h-3.5" />
                                        <User v-else class="w-3.5 h-3.5" />
                                        {{ user.role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <!-- Hide delete for own account -->
                                    <div v-if="user.id !== currentUserId">
                                        <button
                                            @click="confirmUserDeletion(user)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 dark:border-rose-500/30 bg-rose-50 dark:bg-rose-500/10 px-3 py-1.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-500/20 hover:border-rose-300 dark:hover:border-rose-500/50 transition-all"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                            Hapus
                                        </button>
                                    </div>
                                    <!-- Disabled placeholder for self -->
                                    <div v-else class="flex items-center justify-center">
                                        <span class="text-xs text-slate-300 dark:text-slate-600 font-semibold select-none">—</span>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="users.length === 0">
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <Users class="w-8 h-8 text-slate-300 dark:text-slate-600" />
                                        <p class="font-medium">Belum ada user yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal Overlay -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="confirmingUserDeletion" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="cancelUserDeletion">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-slate-900/50 dark:bg-slate-900/70 backdrop-blur-sm"></div>

                <!-- Modal -->
                <div class="relative w-full max-w-md rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl p-6 space-y-5">
                    <!-- Icon & Title -->
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 w-11 h-11 rounded-full bg-rose-100 dark:bg-rose-500/20 flex items-center justify-center">
                            <AlertTriangle class="w-5 h-5 text-rose-600 dark:text-rose-400" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Hapus User</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Tindakan ini tidak dapat dibatalkan. User berikut akan dihapus secara permanen:
                            </p>
                        </div>
                    </div>

                    <!-- User Info Preview -->
                    <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                            {{ confirmingUserDeletion.nama?.charAt(0).toUpperCase() }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-slate-900 dark:text-white text-sm truncate">{{ confirmingUserDeletion.nama }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">@{{ confirmingUserDeletion.username }}</p>
                        </div>
                        <span class="shrink-0 ml-auto text-xs font-bold px-2 py-1 rounded-lg"
                            :class="confirmingUserDeletion.role === 'super_admin' ? 'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20' : 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20'">
                            {{ confirmingUserDeletion.role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-1">
                        <button
                            @click="cancelUserDeletion"
                            class="rounded-xl border border-slate-300 dark:border-slate-600 bg-transparent px-5 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            @click="deleteUser(confirmingUserDeletion.id)"
                            class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-rose-700 transition-colors"
                        >
                            <Trash2 class="w-4 h-4" />
                            Ya, Hapus User
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

    </AuthenticatedLayout>
</template>
