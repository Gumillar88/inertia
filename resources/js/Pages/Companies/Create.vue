<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const form = ref({
  name: '',
  email: '',
  website: '',
  phone: '',
  logo: null, 
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.value.logo = file || null; 
};

const submitForm = async () => {
  const formData = new FormData();
  formData.append('name', form.value.name);
  formData.append('email', form.value.email);
  formData.append('website', form.value.website);
  formData.append('phone', form.value.phone);
  if (form.value.logo) {
    formData.append('logo', form.value.logo); 
  }

  try {
    
    const response = await axios.post('/companies/save', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-TOKEN': csrfToken, 
      },
    });

    Swal.fire({
      title: 'Success!',
      text: response.data.message || 'Company saved successfully!',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      
      window.location.href = '/companies';
    });
  } catch (error) {
    
    Swal.fire({
      title: 'Error!',
      text: error.response?.data?.message || 'An error occurred while saving data.',
      icon: 'error',
      confirmButtonText: 'OK',
    });
    console.error('Error creating company:', error);
  }
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
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Company</h2>

            <!-- Form Create Company -->
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
              <!-- CSRF Token -->
              <input type="hidden" name="_token" :value="csrfToken" />

              <!-- Company Name -->
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input v-model="form.name" type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
              </div>

              <!-- Email -->
              <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="form.email" type="email" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
              </div>

              <!-- Website -->
              <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                <input v-model="form.website" type="url" id="website" name="website" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
              </div>

              <!-- Phone -->
              <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input v-model="form.phone" type="text" id="phone" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>

              <!-- Logo -->
              <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                <input type="file" id="logo" name="logo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @change="handleFileChange" />
              </div>

              <!-- Buttons -->
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
              <a href="/companies" class="ml-4 text-gray-500">Cancel</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
