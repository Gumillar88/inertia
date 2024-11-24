<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import Swal from 'sweetalert2';
import axios from 'axios';
import { ref, onMounted } from 'vue';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const props = defineProps({
  company: Object
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.value.logo = file || null; 
};

const form = ref({
  name: props.company.name || '',
  email: props.company.email || '',
  website: props.company.website || '',
  phone: props.company.phone || '',
});

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
    
    const response = await axios.post(`/companies/update/${props.company.id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-TOKEN': csrfToken, 
      },
    });

    Swal.fire({
      title: 'Success!',
      text: response.data.message || 'Company updated successfully!',
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

// const submitForm = () => {
//   const formData = new FormData();
//   formData.append('name', form.value.name);
//   formData.append('email', form.value.email);
//   formData.append('website', form.value.website);
//   formData.append('phone', form.value.phone);
//   if (form.value.logo) {
//     formData.append('logo', form.value.logo);
//   }

//   put(`/companies/update/${props.company.id}`, formData);
// };

onMounted(() => {
  // Inisialisasi form dengan data perusahaan yang ada
  form.value = {
    name: props.company.name,
    email: props.company.email,
    website: props.company.website,
    phone: props.company.phone,
    logo: null // Inisialisasi logo menjadi null pada edit
  };
});

</script>

<template>
    <Head title="Edit Company" />

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
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Company</h2>

                        <!-- Form Edit Company -->
                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                <input v-model="form.name" type="text" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input v-model="form.email" type="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
                            </div>

                            <div class="mb-4">
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input v-model="form.website" type="url" id="website" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input v-model="form.phone" type="text" id="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            </div>

                            <div class="mb-4">
                                <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                                <input type="file" id="logo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @change="handleFileChange"  />
                                <img v-if="props.company.logo" :src="`/storage/${props.company.logo}`" alt="Logo" class="mt-2 w-32 h-32 object-cover" />
                            </div>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                            <a href="/companies" class="ml-4 text-gray-500">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
