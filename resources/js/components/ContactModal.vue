<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-4">Add Contact</h2>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input v-model="contact.name" type="text" maxlength="20" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input v-model="contact.phone" @input="formatPhoneNumber" type="text" maxlength="20" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
        </div>
        <div class="flex justify-end">
          <button @click="$emit('close')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-2">Cancel</button>
          <button @click="$emit('add', contact)" :disabled="!contact.name || !contact.phone" :class="{ 'bg-gray-400 cursor-not-allowed': !contact.name || !contact.phone }" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Add</button>
        </div>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { defineProps, defineEmits, reactive, watch } from 'vue';

  interface Props {
    isOpen: boolean;
  }

  const props = defineProps<Props>();

  defineEmits(['close', 'add']);

  const contact = reactive({
    name: '',
    phone: '',
  });

  const formatPhoneNumber = () => {
    contact.phone = contact.phone.replace(/[^0-9\s\/\*\#\-\(\)\+]/g, '');
  };

  watch(() => props.isOpen, (newIsOpen) => {
    if (newIsOpen) {
      resetContact();
    }
  });

  const resetContact = () => {
    contact.name = '';
    contact.phone = '';
  };
  </script>
