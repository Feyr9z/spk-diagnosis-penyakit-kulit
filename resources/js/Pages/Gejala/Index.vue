<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    gejala: {
        type: Array,
        required: true,
    },
});

const confirmingDelete = ref(null);

const confirmDelete = (id) => {
    confirmingDelete.value = id;
};

const cancelDelete = () => {
    confirmingDelete.value = null;
};

const hapus = (id) => {
    router.delete(route('gejala.destroy', id), {
        preserveScroll: true,
        onFinish: () => {
            confirmingDelete.value = null;
        },
    });
};
</script>

<template>
    <Head title="Master Gejala" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Master Gejala
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <div class="mb-6 flex justify-end">
                            <Link
                                :href="route('gejala.create')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700"
                            >
                                Tambah Gejala
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            No
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Kode
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Nama Gejala
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Bobot
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="(item, index) in gejala" :key="item.id">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ item.kode }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ item.nama }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                            {{ item.bobot }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm">

                                            <!-- Konfirmasi hapus -->
                                            <template v-if="confirmingDelete === item.id">
                                                <span class="mr-2 text-gray-600 text-xs">Yakin hapus?</span>
                                                <button
                                                    @click="hapus(item.id)"
                                                    class="mr-2 text-red-600 hover:underline text-xs font-semibold"
                                                >
                                                    Ya
                                                </button>
                                                <button
                                                    @click="cancelDelete"
                                                    class="text-gray-500 hover:underline text-xs"
                                                >
                                                    Batal
                                                </button>
                                            </template>

                                            <template v-else>
                                                <Link
                                                    :href="route('gejala.edit', item.id)"
                                                    class="mr-3 text-indigo-600 hover:underline text-sm"
                                                >
                                                    Edit
                                                </Link>
                                                <button
                                                    @click="confirmDelete(item.id)"
                                                    class="text-red-600 hover:underline text-sm"
                                                >
                                                    Hapus
                                                </button>
                                            </template>

                                        </td>
                                    </tr>

                                    <tr v-if="gejala.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data gejala.
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
