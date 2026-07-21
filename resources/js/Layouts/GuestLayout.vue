<script setup>
import { Link } from '@inertiajs/vue3';
import { Activity } from 'lucide-vue-next';
</script>

<template>
    <div class="min-h-screen flex text-slate-300 bg-slate-900 font-sans">
        <!-- Left Side: Artwork/Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-900 items-center justify-center">
            <!-- Decorative gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/50 via-slate-900 to-cyan-900/30"></div>
            <!-- Abstract shapes -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute top-1/4 right-0 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-24 left-1/4 w-80 h-80 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

            <div class="relative z-10 flex flex-col items-center text-center p-12">
                <div class="p-4 bg-slate-800/50 rounded-2xl border border-slate-700/50 backdrop-blur-sm mb-8 shadow-2xl">
                    <Activity class="w-16 h-16 text-indigo-400" />
                </div>
                <h1 class="text-5xl font-extrabold text-white tracking-tight mb-6">Ermust Clinic</h1>
                <p class="text-xl text-slate-400 max-w-lg leading-relaxed">
                    Intelligent Decision Support System powered by Simple Additive Weighting (SAW) algorithm.
                </p>
            </div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-24 relative overflow-hidden">
            <!-- Mobile Background (visible only on small screens) -->
            <div class="lg:hidden absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
            <div class="lg:hidden absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

            <div class="relative z-10 w-full max-w-md backdrop-blur-xl bg-slate-900/80 p-8 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl">
                <!-- Mobile Logo -->
                <div class="flex lg:hidden flex-col items-center mb-10">
                    <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/50 mb-4">
                        <Activity class="w-10 h-10 text-indigo-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Ermust Clinic</h2>
                </div>
                
                <slot />
            </div>
        </div>
    </div>
</template>
