<template>
    <div class="p-4">
      <h1 class="text-3xl font-semibold mb-4">Lista de Tarefas</h1>
      <ul class="space-y-4">
        <li
          v-for="todo in todos"
          :key="todo.id"
          class="flex justify-between items-center p-4 border rounded-md shadow-sm hover:bg-gray-100"
        >
          <span class="text-lg">{{ todo.title }}</span>
          <div class="space-x-2">
            <button
              @click="openEditModal(todo)"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              Editar
            </button>
            <button
              @click="deleteTodo(todo.id)"
              class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            >
              Excluir
            </button>
          </div>
        </li>
      </ul>
  
      <!-- Modal de Edição -->
      <EditTodoModal
        v-if="isEditModalOpen"
        :todo="selectedTodo"
        @close="closeEditModal"
        @save="updateTodo"
      />
    </div>
  </template>
  
  <script>
  import { ref } from "vue";
  import EditTodoModal from "@/components/EditTodoModal.vue";
  
  export default {
    components: {
      EditTodoModal,
    },
    data() {
      return {
        todos: [],
        baseURL: "",
        isEditModalOpen: false,
        selectedTodo: null,
      };
    },
    async mounted() {
      const runtimeConfig = useRuntimeConfig();
      this.baseURL = runtimeConfig.public.baseURL;
      await this.fetchTodos();
    },
    methods: {
      async fetchTodos() {
        try {
          const response = await fetch(`${this.baseURL}/todos`);
          const data = await response.json();
          this.todos = data.data;
        } catch (error) {
          console.error("Erro ao carregar tarefas:", error);
        }
      },
      
      async deleteTodo(id) {
        try {
          const response = await fetch(`${this.baseURL}/todos/${id}`, {
            method: "DELETE",
          });
          if (response.ok) {
            this.fetchTodos(); // Recarrega a lista após a exclusão
          } else {
            console.error("Erro ao excluir tarefa");
          }
        } catch (error) {
          console.error("Erro ao excluir tarefa:", error);
        }
      },
      
      openEditModal(todo) {
        this.selectedTodo = { ...todo }; // Cria uma cópia do todo
        this.isEditModalOpen = true;
      },
      
      closeEditModal() {
        this.isEditModalOpen = false;
      },
  
      async updateTodo(updatedTodo) {
        try {
          const response = await fetch(`${this.baseURL}/todos/${updatedTodo.id}`, {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(updatedTodo),
          });
          if (response.ok) {
            this.fetchTodos();
            this.closeEditModal(); // Fecha o modal após a atualização
          } else {
            console.error("Erro ao atualizar tarefa");
          }
        } catch (error) {
          console.error("Erro ao atualizar tarefa:", error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos adicionais */
  </style>
  