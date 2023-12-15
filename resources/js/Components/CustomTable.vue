<template>
  <div class="columns-3 mb-6">
    <div class="relative">
      <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
      </div>
      <input type="search" v-model="form.search"  id="default-search" class="block w-72 p-3 ps-9 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white " placeholder="Search Mockups, Logos..." required>
    </div>

    <div>
      <select id="countries" v-model="form.category" class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option :value="null" selected>Choose a category</option>
        <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
      </select>
      <button 
        @click="resetFilters" 
        class="text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-gray-400 dark:hover:bg-gray-300 dark:focus:ring-gray-300 dark:border-gray-300">
        Reset Filters
      </button>
    </div>
    
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="tableComponent" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th  scope="col" class="px-6 py-3" v-for="field in fields" :key='field' > 
              <div class="flex items-center">
                {{ field }}
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="item in products.data" :key='item'>
            <td  class="px-6 py-4" v-for="field in fields" :key='field'>
              {{ item[field] }}
            </td>
          </tr>
          <tr v-if="products.data?.length == 0">
            <td class="px-6 py-4 border-t text-center" colspan="5">No data found.</td>
          </tr>
        </tbody>
    </table>
  </div>
  <pagination class="mt-6" :links="products.links" />
</template>
<script>
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import Icon from '@/Components/DataTableComponents/Icon.vue'
import Pagination from '@/Components/DataTableComponents/Pagination.vue'
import { Head, Link } from '@inertiajs/vue3'

export default {
    name: 'TableComponent',
    components: {
      Head,
      Icon,
      Link,
      Pagination,
  },
    props:{
        products: Object,
        fields: {
            type: Array,
        },
        filters: Object,
    }, 
    data() {
      return {
        form: {
          search: this.filters.search,
          category: this.filters.category,
        },
        categories: [
          'Electronics',
          'Clothing',
          'Shoes'
        ],
      }
    },
    watch: {
      form: {
        deep: true,
        handler: throttle(function () {
          this.$inertia.get('/products', pickBy(this.form), { preserveState: true })
        }, 150),
      },
    },
    methods: {
      resetFilters() {
        this.form.search = null;
        this.form.category = null;
      }
    },
  }
</script>