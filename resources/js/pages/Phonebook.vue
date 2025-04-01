<template>
    <div class="min-h-screen bg-gray-100 text-gray-900 p-6 flex items-center justify-center">
      <div class="w-full max-w-2xl bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-3xl font-bold text-gray-800">📖 Contacts</h1>
          <button @click="isModalOpen = true" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Add Contact</button>
        </div>

        <input v-model="searchQuery" type="text" placeholder="🔍 Search by name or phone..." class="w-full border border-gray-300 p-2 rounded-lg text-gray-900 focus:ring focus:ring-blue-200 mb-4" />

        <ul class="space-y-2 max-h-64 overflow-y-auto h-64"> <li v-for="contact in filteredContacts" :key="contact.id" class="flex justify-between items-center bg-gray-50 p-3 rounded-lg shadow-sm border border-gray-200">
            <span class="text-lg">{{ contact.name }} - {{ contact.phone }}</span>
            <button @click="confirmDelete(contact.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition">❌ Delete</button>
          </li>
        </ul>

        <ContactModal :is-open="isModalOpen" @close="isModalOpen = false" @add="addNewContact" />

        <ErrorModal :is-open="isErrorModalOpen" :error-message="apiErrorMessage || errorMessage" @close="isErrorModalOpen = false" />

        <div v-if="isDeleteConfirmationOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Delete</h2>
            <p class="mb-4">Are you sure you want to delete this contact?</p>
            <div class="flex justify-end">
              <button @click="isDeleteConfirmationOpen = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-2">Cancel</button>
              <button @click="deleteContactConfirmed" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, computed, onMounted, Ref } from 'vue';
  import axios, { AxiosResponse } from 'axios';
  import ContactModal from '../components/ContactModal.vue';
  import ErrorModal from '../components/ErrorModal.vue';

  interface Contact {
    id: number;
    name: string;
    phone: string;
  }

  const contacts: Ref<Contact[]> = ref([]);
  const searchQuery: Ref<string> = ref('');
  const isModalOpen: Ref<boolean> = ref(false);
  const isErrorModalOpen: Ref<boolean> = ref(false);
  const errorMessage: Ref<string> = ref('');
  const apiErrorMessage: Ref<string | null> = ref(null);
  const isDeleteConfirmationOpen: Ref<boolean> = ref(false);
  const contactToDeleteId: Ref<number | null> = ref(null);

  const filteredContacts = computed(() => {
    if (!searchQuery.value) return contacts.value;
    return contacts.value.filter(
      (c) => c.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || c.phone.includes(searchQuery.value)
    );
  });

  const fetchContacts = async () => {
    try {
      const response: AxiosResponse<Contact[]> = await axios.get('/api/contacts');
      contacts.value = response.data;
    } catch (error: any) {
      errorMessage.value = error.message;
      isErrorModalOpen.value = true;
      apiErrorMessage.value = null;
    }
  };

  const addNewContact = async (contact: { name: string; phone: string }) => {
    try {
      const response: AxiosResponse<Contact> = await axios.post('/api/contacts', contact);
      contacts.value.push(response.data);
      isModalOpen.value = false;
      apiErrorMessage.value = null;
    } catch (error: any) {
      errorMessage.value = error.message;
      isErrorModalOpen.value = true;
      if (error.response && error.response.data && error.response.data.message) {
        apiErrorMessage.value = error.response.data.message;
      } else {
        apiErrorMessage.value = null;
      }
    }
  };

  const confirmDelete = (id: number) => {
    contactToDeleteId.value = id;
    isDeleteConfirmationOpen.value = true;
  };

  const deleteContactConfirmed = async () => {
    try {
      await axios.delete(`/api/contacts/${contactToDeleteId.value}`);
      contacts.value = contacts.value.filter((c) => c.id !== contactToDeleteId.value);
      apiErrorMessage.value = null;
      isDeleteConfirmationOpen.value = false;
    } catch (error: any) {
      errorMessage.value = error.message;
      isErrorModalOpen.value = true;
      apiErrorMessage.value = null;
    }
  };

  onMounted(fetchContacts);
  </script>
