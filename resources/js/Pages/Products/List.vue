<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from "@/Components/CustomTable.vue";
import { Head, Link } from '@inertiajs/vue3';


const props = defineProps({
  products: Object,
  filters: Object,
})

const fields = [
    'name','price','stock'
]

</script>
<template>
  <Head title="Products" />

  <AuthenticatedLayout>
      <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Products</h2>
          
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit">
                    <Link :href="route('products.create')">Create Product</Link>
                </button>
            </div>
      </template>

      <div class="py-12">
          <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
              <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <Table :fields="fields" :filters="props.filters" :products="props.products"></Table>
              </div>
          </div>
      </div>
  </AuthenticatedLayout>
</template>