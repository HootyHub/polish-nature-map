<script setup>
import { Head } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import NavigationBar from '@/Components/NavigationBar.vue';


defineProps({
  title: String,
});
</script>

<template>
  <Head :title="title" />
  <Toast position="bottom-right" />

  <div class="flex flex-col h-screen">
    <NavigationBar />
    <div class="flex flex-col overflow-y-auto">
      <slot />
    </div>
  </div>
</template>
