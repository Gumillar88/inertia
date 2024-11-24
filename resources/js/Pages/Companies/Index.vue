<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
  companies: Array
});

const { props: pageProps } = usePage();

const columns = [
    {
        title: 'Company Name',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },
    {
        title: 'Website',
        dataIndex: 'website',
        key: 'website',
    },
    {
        title: 'Actions',
        key: 'actions',
        scopedSlots: { customRender: 'actions' },
    },
];

const pagination = reactive({
    current: pageProps.companies?.current_page || 1,
    pageSize: pageProps.companies?.per_page || 10,
    total: pageProps.companies?.total || 0,
});

const handleTableChange = (pagination) => {
    console.log('Pagination Changed: ', pagination);
};

const editCompany = (id) => {
    console.log(`Editing company with ID: ${id}`);
};

const deleteCompany = (id) => {
    console.log(`Deleting company with ID: ${id}`);
};
</script>

<template>
    <Head title="Companies" />

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
                        <h2 class="text-2xl font-semibold leading-tight text-gray-800">Companies</h2>
                        <p class="text-gray-500">List of all companies in the system</p>
                        </div>
                        <div>
                        <!-- Tombol Create -->
                        <a href="/companies/create" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Create Company
                        </a>
                        </div>
                    </div>

                    <table class="min-w-full table-auto">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left py-2 px-4 border-b">Company Name</th>
                            <th class="text-left py-2 px-4 border-b">Email</th>
                            <th class="text-left py-2 px-4 border-b">Website</th>
                            <th class="text-left py-2 px-4 border-b">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="company in companies" :key="company.id">
                                <td class="text-centen py-2 px-4 border-b">{{ company.name }}</td>
                                <td class="text-centen py-2 px-4 border-b">{{ company.email }}</td>
                                <td class="text-centen py-2 px-4 border-b">{{ company.website }}</td>
																<td class="text-centen py-2 px-4 border-b">
																	<a :href="`/employees/${company.id}/edit`" class="bg-green-500 text-white px-4 p-2 m-2 rounded-md" @click="editCompany(company.id)">Edit</a>
																	<a href="#" class="bg-red-500 text-white px-4 p-2 m-2 rounded-md" @click="deleteCompany(company.id)">Delete</a>
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
