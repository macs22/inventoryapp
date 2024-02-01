<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { reactive } from 'vue'
import { router, Head, useForm, Link } from '@inertiajs/vue3'

const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: props.product.name,
    price: props.product.price,
    stock: props.product.stock,
});

const submit = () => {
    form.put(route("products.update", props.product.id));
};
</script>

<template>
    <Head title="Products" />
  
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-sky-800"><Link :href="route('products')">Products</Link></h2>
            
        </template>
  
        <div class="py-12">
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md" @submit.prevent="submit">
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                                Product Name
                            </label>
                            <input v-model="form.name" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" autocomplete="off" type="text" placeholder="Product name">
                            <div v-if="form.errors.name" class="text-xs italic text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="price">
                                Price
                            </label>
                            <input v-model="form.price" class="w-full px-3 py-2 mb-3 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="number" placeholder="$" min="0">
                            <div v-if="form.errors.price" class="text-xs italic text-red-500">{{ form.errors.price }}</div>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="stock">
                                Stock
                            </label>
                            <input v-model="form.stock" class="w-full px-3 py-2 mb-3 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="number" placeholder="stock" min="0">
                            <div v-if="form.errors.stock" class="text-xs italic text-red-500">{{ form.errors.stock }}</div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
