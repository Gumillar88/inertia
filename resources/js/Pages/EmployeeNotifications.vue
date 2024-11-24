<template>
  <div v-if="visible" class="fixed top-4 right-4 w-80 bg-green-500 text-white p-4 rounded-md shadow-lg transition-all opacity-100" :class="{'opacity-100': visible, 'opacity-0': !visible}">
    <div class="flex justify-between items-center">
      <span>This Notification</span>
      <button @click="closeNotification" class="text-white font-bold">X</button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  message: String, 
});

const visible = ref(true);

const closeNotification = () => {
  visible.value = false;
};

watch(visible, (newValue) => {
  if (newValue) {
    setTimeout(() => {
      visible.value = false;
    }, 5000);
  }
});
</script>

<style scoped>
@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(-20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.fixed {
  animation: fadeIn 1s ease-out;
}
</style>
