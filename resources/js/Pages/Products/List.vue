<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, Head } from '@inertiajs/vue3'
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";


defineProps({ products: Array })
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        Product List <hr><br>
                        <Table 
                            :striped="true"
                            :prevent-overlapping-requests="false"
                            :input-debounce-ms="1000"
                            :preserve-scroll="true"
                            :resource="products" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>