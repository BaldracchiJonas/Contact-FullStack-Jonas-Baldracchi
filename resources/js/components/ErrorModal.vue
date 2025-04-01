<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ errorMessage }}</span>
        <span @click="$emit('close')" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
          <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l3.029-3.03-3.029-3.028a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-3.03 3.029 3.03 3.03a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { defineProps, defineEmits } from 'vue';

  defineProps({
    isOpen: Boolean,
    errorMessage: String,
  });

  defineEmits(['close']);
  </script>
