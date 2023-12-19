<template>
  <div class="columns-3 mb-4">
    <div class="relative mb-2 flex flex-wrap items-stretch">
      <label
        for="default-search"
        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
        >Search</label
      >
      <div
        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
      >
        <svg
          class="w-4 h-4 text-gray-500 dark:text-gray-400"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 20 20"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
          />
        </svg>
      </div>
      <input
        type="search"
        v-model="form.search"
        id="default-search"
        class="block w-72 p-3 ps-9 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
        placeholder="Search products"
        required
      />
    </div>
    <div class="relative mb-2 flex flex-wrap items-stretch">
      <select
        id="countries"
        v-model="form.category"
        class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      >
        <option :value="null" selected>Choose a category</option>
        <option
          v-for="category in categories"
          :key="category"
          :value="category"
        >
          {{ category }}
        </option>
      </select>
      <button
        @click="resetFilters"
        class="text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-gray-400 dark:hover:bg-gray-300 dark:focus:ring-gray-300 dark:border-gray-300"
      >
        Reset Filters
      </button>
    </div>
  </div>

  <div class="flex items-end">
    <!-- Settings Dropdown -->
    <div class="ms-3 relative">
      <Dropdown align="right" width="50">
        <template #trigger>
          <span class="inline-flex rounded-md">
            <button
              type="button"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
              Columns
              <svg
                class="ms-2 -me-0.5 h-4 w-4"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </span>
        </template>

        <template #content>
          <ul
            v-for="(header, index) in fields"
            :key="header"
            class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="dropdownToggleButton"
          >
            <li>
              <div
                class="flex p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
              >
                <label
                  class="relative inline-flex items-center w-full cursor-pointer"
                >
                  <input
                    type="checkbox"
                    v-on:change="toggleColumn(index)"
                    checked
                    value="checked"
                    class="sr-only peer"
                  />
                  <div
                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:translate-x-[-100%] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"
                  ></div>
                  <span
                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >{{ header.toUpperCase() }}</span
                  >
                </label>
              </div>
            </li>
          </ul>
        </template>
      </Dropdown>
    </div>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table
      id="tableComponent"
      class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
    >
      <thead
        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
      >
        <tr>
          <th
            scope="col"
            class="px-6 py-3"
            v-for="header in visibleHeaders"
            :key="header"
          >
            {{ header }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          v-for="(row, index) in products.data"
          :key="index"
        >
          <td class="px-6 py-4" v-for="header in visibleHeaders" :key="header">
            {{ row[header] }}
          </td>
        </tr>
        <tr v-if="products.data?.length == 0">
          <td class="px-6 py-4 border-t text-center" colspan="5">
            No data found.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <pagination class="mt-6" :links="products.links" />
</template>
<script>
import { ref } from 'vue';
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import Icon from '@/Components/DataTableComponents/Icon.vue'
import Pagination from '@/Components/DataTableComponents/Pagination.vue'
import { Head, Link } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue'


const showingNavigationDropdown = ref(false);

export default {
    name: 'TableComponent',
    components: {
      Head,
      Icon,
      Link,
      Pagination,
      Dropdown
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
        visibleColumns: [],
        dropdownToggle: false,
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
    computed: {
      visibleHeaders: function() {
        if (this.visibleColumns === 0) {
          return this.fields;
        } else {
          return this.fields.filter((header, key) => !this.visibleColumns.includes(key))
        }
      }
    },
    methods: {
      resetFilters() {
        this.form.search = null;
        this.form.category = null;
      },
      toggleColumn(columnKey) {
        var index = this.visibleColumns.indexOf(columnKey);
        if (index === -1) {
          this.visibleColumns.push(columnKey);
        } else {
          this.visibleColumns.splice(index, 1);
        }
      },
      showColumnDropdown() {
        this.dropdownToggle = true;
      }
    },
  }
</script>
