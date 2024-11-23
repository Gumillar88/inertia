<template>
  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Employee</h2>

          <!-- Form Edit Employee -->
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
              <input v-model="form.first_name" type="text" id="first_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
            </div>

            <div class="mb-4">
              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
              <input v-model="form.last_name" type="text" id="last_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
            </div>

            <div class="mb-4">
              <label for="company_id" class="block text-sm font-medium text-gray-700">Company</label>
              <select v-model="form.company_id" id="company_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input v-model="form.email" type="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
            </div>

            <div class="mb-4">
              <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
              <input v-model="form.phone" type="text" id="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
            <a href="/employees" class="ml-4 text-gray-500">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, useForm } from '@inertiajs/inertia-vue3';

const { employee, companies } = usePage().props;

const form = ref({
  first_name: employee.first_name,
  last_name: employee.last_name,
  company_id: employee.company_id,
  email: employee.email,
  phone: employee.phone
});

const { put } = useForm();

const submitForm = () => {
  put(`/employees/${employee.id}`, form.value);
};
</script>
