<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    penyakit: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    kode: props.penyakit.kode,
    nama: props.penyakit.nama,
    deskripsi: props.penyakit.deskripsi,
    solusi: props.penyakit.solusi,
});

const submit = () => {
    form.put(route('penyakit.update', props.penyakit.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Edit Penyakit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Penyakit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <form @submit.prevent="submit" class="space-y-5">

                            <!-- Kode -->
                            <div>
                                <label for="kode" class="block text-sm font-medium text-gray-700">
                                    Kode Penyakit
                                </label>
                                <input
                                    id="kode"
                                    v-model="form.kode"
                                    type="text"
                                    maxlength="20"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.kode }"
                                />
                                <p v-if="form.errors.kode" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.kode }}
                                </p>
                            </div>

                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">
                                    Nama Penyakit
                                </label>
                                <input
                                    id="nama"
                                    v-model="form.nama"
                                    type="text"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.nama }"
                                />
                                <p v-if="form.errors.nama" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.nama }}
                                </p>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                                    Deskripsi
                                </label>
                                <textarea
                                    id="deskripsi"
                                    v-model="form.deskripsi"
                                    rows="4"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.deskripsi }"
                                ></textarea>
                                <p v-if="form.errors.deskripsi" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.deskripsi }}
                                </p>
                            </div>

                            <!-- Solusi -->
                            <div>
                                <label for="solusi" class="block text-sm font-medium text-gray-700">
                                    Solusi
                                </label>
                                <textarea
                                    id="solusi"
                                    v-model="form.solusi"
                                    rows="4"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.solusi }"
                                ></textarea>
                                <p v-if="form.errors.solusi" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.solusi }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <Link
                                    :href="route('penyakit.index')"
                                    class="rounded-md border px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 disabled:opacity-50"
                                >
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
