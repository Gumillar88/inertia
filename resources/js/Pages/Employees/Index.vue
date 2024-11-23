
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
  employees: Array
});

const { props: pageProps } = usePage();
const employees = ref(pageProps.employees || []);

const columns = [
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },
    {
        title: 'Role',
        dataIndex: 'role',
        key: 'role',
    },
    {
        title: 'Actions',
        key: 'actions',
        scopedSlots: { customRender: 'actions' },
    },
];

const pagination = reactive({
    current: pageProps.employees?.current_page || 1,
    pageSize: pageProps.employees?.per_page || 10,
    total: pageProps.employees?.total || 0,
});

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
    <Head title="Dashboard" />

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
                            <th class="py-2 px-4 border-b">First Name</th>
                            <th class="py-2 px-4 border-b">Last Name</th>
                            <th class="py-2 px-4 border-b">Company</th>
                            <th class="py-2 px-4 border-b">Email</th>
                            <th class="py-2 px-4 border-b">Phone</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="employee in employees" :key="employee.id">
                            <td class="py-2 px-4 border-b">{{ employee.first_name }}</td>
                            <td class="py-2 px-4 border-b">{{ employee.last_name }}</td>
                            <td class="py-2 px-4 border-b">{{ employee.company_id }}</td>
                            <td class="py-2 px-4 border-b">{{ employee.email }}</td>
                            <td class="py-2 px-4 border-b">{{ employee.phone }}</td>
                            <td class="py-2 px-4 border-b">
                            <!-- Tombol Edit dan Delete per row -->
                            <a href="#" class="text-blue-500" @click="editEmployee(employee.id)">Edit</a>
                            <a href="#" class="text-red-500 ml-2" @click="deleteEmployee(employee.id)">Delete</a>
                            </td>
                        </tr>
                        <!-- Jika tidak ada data -->
                        <tr v-if="employees.length === 0">
                            <td colspan="4" class="py-2 px-4 border-b text-center">No employees found.</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        <pagination 
                        :current="pagination.current" 
                        :page-size="pagination.pageSize" 
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


