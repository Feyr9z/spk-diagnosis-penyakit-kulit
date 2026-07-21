<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    gejala: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    nama: '',
    usia: '',
    jenis_kelamin: '',
    gejala_ids: [],
});

const toggleGejala = (id) => {
    const index = form.gejala_ids.indexOf(id);
    if (index === -1) {
        form.gejala_ids.push(id);
    } else {
        form.gejala_ids.splice(index, 1);
    }
};

const submit = () => {
    form.post(route('diagnosis.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Diagnosis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Diagnosis Penyakit Kulit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">

                <!-- Data Pasien -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-base font-semibold text-gray-800">Data Pasien</h3>

                        <div class="space-y-4">

                            <!-- Nama Pasien -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">
                                    Nama Pasien
                                </label>
                                <input
                                    id="nama"
                                    v-model="form.nama"
                                    type="text"
                                    maxlength="100"
                                    placeholder="Masukkan nama pasien"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.nama }"
                                />
                                <p v-if="form.errors.nama" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.nama }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">

                                <!-- Usia -->
                                <div>
                                    <label for="usia" class="block text-sm font-medium text-gray-700">
                                        Usia (tahun)
                                    </label>
                                    <input
                                        id="usia"
                                        v-model="form.usia"
                                        type="number"
                                        min="1"
                                        max="255"
                                        placeholder="Contoh: 25"
                                        class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        :class="{ 'border-red-500': form.errors.usia }"
                                    />
                                    <p v-if="form.errors.usia" class="mt-1 text-xs text-red-600">
                                        {{ form.errors.usia }}
                                    </p>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">
                                        Jenis Kelamin
                                    </label>
                                    <select
                                        id="jenis_kelamin"
                                        v-model="form.jenis_kelamin"
                                        class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        :class="{ 'border-red-500': form.errors.jenis_kelamin }"
                                    >
                                        <option value="" disabled>-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <p v-if="form.errors.jenis_kelamin" class="mt-1 text-xs text-red-600">
                                        {{ form.errors.jenis_kelamin }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pilih Gejala -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-1 text-base font-semibold text-gray-800">Pilih Gejala</h3>
                        <p class="mb-4 text-sm text-gray-500">
                            Pilih gejala yang dialami pasien. Minimal satu gejala harus dipilih.
                        </p>

                        <p v-if="form.errors.gejala_ids" class="mb-3 text-sm text-red-600">
                            {{ form.errors.gejala_ids }}
                        </p>

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <label
                                v-for="item in gejala"
                                :key="item.id"
                                class="flex cursor-pointer items-start gap-3 rounded-md border p-3 transition hover:bg-indigo-50"
                                :class="{ 'border-indigo-500 bg-indigo-50': form.gejala_ids.includes(item.id) }"
                            >
                                <input
                                    type="checkbox"
                                    :value="item.id"
                                    :checked="form.gejala_ids.includes(item.id)"
                                    @change="toggleGejala(item.id)"
                                    class="mt-0.5 h-4 w-4 rounded border-gray-300 text-indigo-600"
                                />
                                <span class="text-sm text-gray-700">
                                                <span class="font-medium text-gray-900">{{ item.kode_gejala }}</span>
                                                — {{ item.nama_gejala }}
                                                <span class="text-xs text-gray-400">(bobot: {{ item.bobot }})</span>
                                            </span>
                            </label>
                        </div>

                        <p v-if="gejala.length === 0" class="text-sm text-gray-500">
                            Belum ada data gejala. Tambahkan gejala terlebih dahulu.
                        </p>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button
                        type="button"
                        :disabled="form.processing"
                        @click="submit"
                        class="rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Memproses...' : 'Proses Diagnosis' }}
                    </button>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
