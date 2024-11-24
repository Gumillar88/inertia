<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

import { shallowRef } from 'vue';

const { props } = usePage();
const employees = ref(props.employees || []);
const pagination = shallowRef(props.pagination || { current_page: 1, per_page: 10, total: 0 });

console.log("this data: " + employees);

const columns = [
  { title: 'First Name', dataIndex: 'first_name', key: 'first_name' },
  { title: 'Last Name', dataIndex: 'last_name', key: 'last_name' },
  { title: 'Company', dataIndex: 'company', key: 'company', customRender: (text, record) => record.company?.name || 'N/A' },
  { title: 'Email', dataIndex: 'email', key: 'email' },
  { title: 'Phone', dataIndex: 'phone', key: 'phone' },
  { title: 'Actions', key: 'actions', scopedSlots: { customRender: 'actions' } },
];

const handleTableChange = (pagination) => {
  console.log('Pagination Changed: ', pagination);
};

const editEmployee = (id) => {
  console.log(`Editing employee with ID: ${id}`);
};

const deleteEmployee = (id) => {
  console.log(`Deleting employee with ID: ${id}`);
};
</script>

<template>
  <Head title="Employees" />

  <AuthenticatedLayout>
    <template #header>
      <ul class="flex space-x-6">
        <li>
          <a href="/dashboard" class="text-xl font-semibold leading-tight text-gray-800 hover:text-blue-500">
            Dashboard
          </a>
        </li>
        <li>
          <a href="/employees" class="text-xl font-semibold leading-tight text-gray-800 hover:text-blue-500">
            Employees
          </a>
        </li>
        <li>
          <a href="/companies" class="text-xl font-semibold leading-tight text-gray-800 hover:text-blue-500">
            Companies
          </a>
        </li>
      </ul>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <!-- Dashboard Header -->
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-semibold leading-tight text-gray-800">Employees</h2>
                <p class="text-gray-500">List of all employees in the system</p>
              </div>
              <div>
                <!-- Tombol Create -->
                <a href="/employees/create" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                  Create Employee
                </a>
              </div>
            </div>

            <!-- Tabel Karyawan -->
            <table class="min-w-full table-auto">
              <thead>
                <tr class="bg-gray-100">
                  <!-- Looping kolom tabel -->
                  <th v-for="column in columns" :key="column.key" class="py-2 px-4 border-b">
                    {{ column.title }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                  <td v-for="column in columns" :key="column.key" class="py-2 px-4 border-b">
                    <span v-if="column.customRender">
                      {{ column.customRender(null, employee) }}
                    </span>
                    <span v-else>
                      {{ employee[column.dataIndex] || 'N/A' }}
                    </span>
                  </td>
                  <td class="py-2 px-4 border-b">
                    <a href="#" class="text-blue-500" @click="editEmployee(employee.id)">Edit</a>
                    <a href="#" class="text-red-500 ml-2" @click="deleteEmployee(employee.id)">Delete</a>
                  </td>
                </tr>
                <tr v-if="employees.length === 0">
                  <td colspan="7" class="py-2 px-4 border-b text-center">No employees found.</td>
                </tr>
              </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
              <pagination 
                :current="pagination.current_page" 
                :page-size="pagination.per_page" 
                :total="pagination.total" 
                @change="handleTableChange" 
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>