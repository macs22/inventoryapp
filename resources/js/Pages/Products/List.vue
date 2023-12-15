<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from "@/Components/CustomTable.vue";
import { Head, Link } from '@inertiajs/vue3';


const props = defineProps({
  products: Object,
  filters: Object,
})

const fields = [
  'id','name','price','stock','category'
]

</script>
<template>
  <Head title="Products" />

  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
              <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <Table :fields="fields" :filters="props.filters" :products="props.products"></Table>
              </div>
          </div>
      </div>
  </AuthenticatedLayout>
</template>