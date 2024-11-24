<template>
  <div>
    <ul>
      <li v-for="(message, index) in messages" :key="index">
        {{ message }}
      </li>
    </ul>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Pusher from 'pusher-js';

export default {
  setup() {
    const messages = ref([]);

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    const pusher = new Pusher('44f1ab2c70d64de9dd04', {
      cluster: 'ap1'
    });

    const channel = pusher.subscribe('my-channel');
    channel.bind('my-event', (data) => {
      messages.value.push(JSON.stringify(data));
    });

    return {
      messages
    };
  }
};
</script>

<style scoped>
/* Optional styling */
</style>
