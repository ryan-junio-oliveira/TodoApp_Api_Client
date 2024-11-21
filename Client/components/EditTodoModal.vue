<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-2xl font-semibold mb-4">Editar Tarefa</h2>
        <form @submit.prevent="saveTodo">
          <div class="mb-4">
            <label for="title" class="block text-gray-700">Título</label>
            <input
              type="text"
              id="title"
              v-model="editedTodo.title"
              class="w-full p-2 border border-gray-300 rounded-md"
              required
            />
          </div>
  
          <div class="flex justify-between items-center">
            <button
              type="button"
              @click="closeModal"
              class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
              Cancelar
            </button>
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      todo: Object,
    },
    data() {
      return {
        editedTodo: { ...this.todo },
      };
    },
    methods: {
      saveTodo() {
        this.$emit("save", this.editedTodo); // Emite o evento para salvar
      },
      
      closeModal() {
        this.$emit("close"); // Emite o evento para fechar o modal
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos do modal */
  </style>
  