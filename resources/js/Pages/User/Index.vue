<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    users: {
        type: Array,
        required: true,
    },
});
</script>

<template>

    <Head title="Manajemen User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manajemen User
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <div class="mb-6 flex justify-end">
                            <Link :href="route('users.create')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                                Tambah User
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Nama
                                        </th>

                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Email
                                        </th>

                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Role
                                        </th>

                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="user in users" :key="user.id">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ user.name }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ user.email }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ user.role }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-center">
                                            <button class="mr-2 text-indigo-600 hover:underline">
                                                Edit
                                            </button>

                                            <button class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>

                                    <tr v-if="users.length === 0">
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data user.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
