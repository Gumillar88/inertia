<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>
<script>
import EmployeeNotifications from '@/Pages/EmployeeNotifications.vue';

export default {
  components: {
    EmployeeNotifications
  }
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <EmployeeNotifications />
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
                    <!-- Notification Component -->
                    <EmployeeNotifications v-for="(message, index) in messages" :key="index" :message="message" />
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>