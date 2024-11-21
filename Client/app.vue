<template>
  <header class="bg-gray-800 p-4 shadow-md">
    <nav>
      <div class="flex justify-between items-center">
        <!-- Logo ou título -->
        <div class="text-white font-semibold text-2xl">
          <NuxtLink to="/">Meu TodoApp</NuxtLink>
        </div>

        <!-- Botão de menu para mobile -->
        <div class="lg:hidden">
          <button @click="toggleMenu" class="text-white focus:outline-none">
            <svg v-if="isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>

        <!-- Menu de navegação -->
        <div :class="{'hidden': !isMenuOpen, 'block': isMenuOpen}" class="lg:flex lg:space-x-6 text-white">
          <ul class="flex space-x-6">
            <li>
              <NuxtLink to="/" class="hover:text-gray-300">Home</NuxtLink>
            </li>
            <!-- Adicione outros links aqui -->
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="p-4">
    <NuxtPage />
  </main>
</template>

<script setup>
import { ref } from "vue";

const isMenuOpen = ref(false);

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>

<style scoped>
/* Estilo adicional para o menu */
nav ul {
  list-style-type: none;
  padding: 0;
}

nav ul li {
  transition: all 0.3s ease;
}

nav ul li:hover {
  text-decoration: underline;
}

nav a {
  text-decoration: none;
}

@media (max-width: 1024px) {
  .lg\:flex {
    display: none;
  }

  .block {
    display: block;
    background-color: rgba(0, 0, 0, 0.9);
    padding: 10px;
    position: absolute;
    top: 64px;
    left: 0;
    right: 0;
    z-index: 10;
  }

  .block ul {
    flex-direction: column;
    text-align: center;
  }

  .block ul li {
    margin: 10px 0;
  }
}
</style>
