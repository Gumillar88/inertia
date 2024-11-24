<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
  employees: Array
});

const { props: pageProps } = usePage();

const columns = [
  { title: 'First Name', dataIndex: 'first_name', key: 'first_name' },
  { title: 'Last Name', dataIndex: 'last_name', key: 'last_name' },
  { title: 'Company', dataIndex: 'company', key: 'company', customRender: (text, record) => record.company?.name || 'N/A' },
  { title: 'Email', dataIndex: 'email', key: 'email' },
  { title: 'Phone', dataIndex: 'phone', key: 'phone' },
  { title: 'Actions', key: 'actions', scopedSlots: { customRender: 'actions' } },
];

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
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-semibold leading-tight text-gray-800">Employees</h2>
                <p class="text-gray-500">List of all employees in the system</p>
              </div>
              <div>
                <a href="/employees/create" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                  Create Employee
                </a>
              </div>
            </div>

            <table class="min-w-full table-auto">
              <thead>
                <tr class="bg-gray-100">
                  <th v-for="column in columns" :key="column.key" class="py-2 px-4 border-b">
                    {{ column.title }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees" :key="employee.id">
										<td class="text-centen py-2 px-4 border-b">{{ employee.first_name }}</td>
										<td class="text-centen py-2 px-4 border-b">{{ employee.last_name }}</td>
										<td class="text-centen py-2 px-4 border-b">{{ employee.company_id }}</td>
										<td class="text-centen py-2 px-4 border-b">{{ employee.email }}</td>
										<td class="text-centen py-2 px-4 border-b">{{ employee.phone }}</td>
										<td class="text-centen py-2 px-4 border-b">
											<a :href="`/employees/${employee.id}/edit`" class="bg-green-500 text-white px-4 p-2 m-2 rounded-md" @click="editEmployee(employee.id)">Edit</a>
											<a href="#" class="bg-red-500 text-white px-4 p-2 m-2 rounded-md" @click="deleteEmployee(employee.id)">Delete</a>
										</td>
								</tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
