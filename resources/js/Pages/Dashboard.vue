<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="text-5xl text-gray-600">
                            Hi! Welcome to <span class="text-blue-700 font-extrabold">Aubrey</span>'s Simple Inventory App
                        </p>
                        <p class="mt-8 text-center">
                            <Link
                                :href="route('products.list')"
                                class="underline text-3xl text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                See Product List Here!
                            </Link>
                        </p>
                    </div>  
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
