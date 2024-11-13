<template>
    <nav class="navbar">
      <div class="navbar-container">
        <!-- Logo personalizado con "BodyFit" -->
        <a href="/" class="logo">
          <span class="logo-body">Body</span><span class="logo-fit">Fit</span>
        </a>
  
        <!-- Selector de Estilos -->
        <div class="style-selector">
          <label for="style-select">Selecciona un estilo:</label>
          <select id="style-select" v-model="selectedStyle" @change="updateStyles">
            <option value="defecto">Cliente</option>
            <option value="ninos">Niños</option>
            <option value="jovenes">Jóvenes</option>
            <option value="adultos">Adultos</option>
          </select>
        </div>
  
        <!-- Switch de Modo Claro/Oscuro -->
        <div class="mode-switch">
          <label for="mode-switch">Modo:</label>
          <label class="switch">
            <input type="checkbox" v-model="isDarkMode" @change="updateStyles" />
            <span class="slider"></span>
          </label>
          <span>{{ isDarkMode ? 'Oscuro' : 'Claro' }}</span>
        </div>
  
        <!-- Menú principal simplificado -->
        <ul class="nav-links" :class="{ open: isMenuOpen }">
          <li class="nav-item">
            <a href="/mis-membresias">Mis Membresías</a>
          </li>
          <li class="nav-item">
            <a href="/comprar-productos">Comprar Productos</a>
          </li>
        </ul>
        <div class="user-info">
          <span class="greeting">Hola, Usuario</span>
          <button @click="logout" class="logout-btn">Cerrar Sesión</button>
          <Link :href="route('logout')" method="post" class="logout-btn">Cerrar Sesión</Link>
        </div>
        <button @click="toggleMobileMenu" class="menu-toggle">
          {{ isMenuOpen ? 'Cerrar' : 'Desplegar' }}
        </button>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    name: "NavBar",
    data() {
      return {
        isMenuOpen: false,
        selectedStyle: "defecto",
        isDarkMode: false,
      };
    },
    methods: {
      toggleMobileMenu() {
        this.isMenuOpen = !this.isMenuOpen;
      },
      logout() {
        console.log("Cerrando sesión");
      },
      updateStyles() {
        const selectedHref = this.currentStyles[this.selectedStyle];
        const existingLinks = document.querySelectorAll('link[rel="stylesheet"]');
        existingLinks.forEach(link => link.remove());
  
        const linkTag = document.createElement("link");
        linkTag.rel = "stylesheet";
        linkTag.href = selectedHref;
        document.head.appendChild(linkTag);
      },
    },
    computed: {
      currentStyles() {
        return {
          defecto: this.isDarkMode
            ? "/css/estiloPagClienteOscuro.css"
            : "/css/estiloPagClienteClaro.css",
          ninos: this.isDarkMode
            ? "/css/estiloPagNinoOscuro.css"
            : "/css/estiloPagNinoClaro.css",
          jovenes: this.isDarkMode
            ? "/css/estiloPagJovenOscuro.css"
            : "/css/estiloPagJovenClaro.css",
          adultos: this.isDarkMode
            ? "/css/estiloPagAdultoOscuro.css"
            : "/css/estiloPagAdultoClaro.css",
        };
      },
    },
    mounted() {
      this.updateStyles();
    },
  };
  </script>
  
  <style scoped>
  /* Estilo para el switch */
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }
  
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
  }
  
  input:checked + .slider {
    background-color: #d80000;
  }
  
  input:checked + .slider:before {
    transform: translateX(26px);
  }
  </style>
  
