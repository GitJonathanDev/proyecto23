<template>
    <nav class="navbar">
      <div class="navbar-container">
        <!-- Logo personalizado con "BodyFit" -->
        <a href="/" class="logo">
          <span class="logo-body">Body</span><span class="logo-fit">Fit</span>
        </a>
        
        <!-- Menú principal con opciones desplegables tipo acordeón -->
        <ul class="nav-links">
          <li class="nav-item">
            <button @click="toggleMenu('compra')" class="accordion-toggle">Modulo Compra</button>
            <ul v-if="activeMenu === 'compra'" class="dropdown-content">
              <li><a href="/proveedor/index">Gestionar Proveedor</a></li>
              <li><a href="/producto/index">Gestionar Producto</a></li>
              <li><a href="/categoria/index">Gestionar Categoría</a></li>
              <li><a href="/compra/index">Resalizar Compra</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <button @click="toggleMenu('venta')" class="accordion-toggle">Modulo Venta</button>
            <ul v-if="activeMenu === 'venta'" class="dropdown-content">
              <li><a href="/venta/index">Realizar Venta</a></li>
              <li><a href="/cliente/index">Gestionar Cliente</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <button @click="toggleMenu('membresia')" class="accordion-toggle">Modulo Membresía</button>
            <ul v-if="activeMenu === 'membresia'" class="dropdown-content">
              <li><a href="/membresia/index">Gestionar Membresia</a></li>
              <li><a href="/horario/index">Gestionar Horario</a></li>
              <li><a href="/servicio/index">Gestionar Servicio</a></li>
              <li><a href="/precioServicio/index">Gestionar Precio Servicio</a></li>
            </ul>
          </li>
        </ul>
    
        <!-- Saludo y Cerrar sesión -->
        <div class="user-info">
          <span class="greeting">Hola, Usuario</span>
          <button @click="logout" class="logout-btn">Cerrar Sesión</button>
        </div>
  
        <!-- Botón de menú para móviles -->
        <button @click="isMenuOpen = !isMenuOpen" class="menu-toggle md:hidden">
          <i :class="isMenuOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
        </button>
      </div>
    
      <!-- Menú desplegable para móviles -->
      <ul v-if="isMenuOpen" class="nav-links-mobile md:hidden">
        <li class="nav-item">
          <button @click="toggleMenu('compra')" class="accordion-toggle">Modulo Compra</button>
          <ul v-if="activeMenu === 'compra'" class="dropdown-content">
            <li><a href="/productos">Productos</a></li>
            <li><a href="/historial-compras">Historial de Compras</a></li>
            <li><a href="/proveedores">Proveedores</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <button @click="toggleMenu('venta')" class="accordion-toggle">Modulo Venta</button>
          <ul v-if="activeMenu === 'venta'" class="dropdown-content">
            <li><a href="/realizar-venta">Realizar Venta</a></li>
            <li><a href="/historial-ventas">Historial de Ventas</a></li>
            <li><a href="/facturacion">Facturación</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <button @click="toggleMenu('membresia')" class="accordion-toggle">Modulo Membresía</button>
          <ul v-if="activeMenu === 'membresia'" class="dropdown-content">
            <li><a href="/planes-membresia">Planes de Membresía</a></li>
            <li><a href="/renovacion">Renovación</a></li>
            <li><a href="/historial-membresias">Historial de Membresías</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'NavBar',
    data() {
      return { 
        isMenuOpen: false,
        activeMenu: null
      };
    },
    methods: {
      toggleMenu(menu) {
        this.activeMenu = this.activeMenu === menu ? null : menu;
      },
      logout() {
        // Lógica para cerrar sesión (por ejemplo, redirigir al login o borrar el token)
        console.log('Cerrando sesión');
        // Aquí va el código para cerrar la sesión, como redirigir a la página de login o borrar el token.
      }
    }
  };
  </script>
  
  <style scoped>
  /* Navbar General */
  .navbar {
    position: fixed;
    top: 0;
    width: 100%;
    background-color: #1f1f1f;
    color: #fff;
    padding: 10px 0;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    z-index: 1000;
  }
  
  .navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }
  
  .logo {
    font-size: 1.75rem;
    font-weight: bold;
    text-decoration: none;
  }
  
  .logo-body {
    color: #ffffff;
  }
  
  .logo-fit {
    color: #ff0000;
  }
  
  .nav-links {
    display: flex;
    gap: 30px;
  }
  
  .menu-toggle {
    color: white;
    font-size: 2rem;
    padding: 0 10px;
  }
  
  .accordion-toggle {
    font-weight: bold;
    color: #ffffff;
    background: none;
    border: none;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: color 0.3s ease;
  }
  
  .accordion-toggle:hover {
    color: #ff0000;
  }
  
  .dropdown-content {
    position: absolute;
    background-color: #333;
    padding: 15px;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    margin-top: 10px;
    min-width: 180px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 999;
  }
  
  .dropdown-content a {
    color: #ffffff;
    text-decoration: none;
    font-size: 1.1rem;
    padding: 15px 0;
    margin-bottom: 15px;
    padding-left: 20px;
    transition: color 0.3s ease;
  }
  
  .dropdown-content a:hover {
    color: #ff0000;
  }
  
  /* Estilo para el saludo y cerrar sesión */
  .user-info {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  
  .greeting {
    color: #ffffff;
    font-size: 1.2rem;
  }
  
  .logout-btn {
    background-color: #ff0000;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 1rem;
    border-radius: 5px;
  }
  
  .logout-btn:hover {
    background-color: #cc0000;
  }
  
  /* Estilos para la versión móvil */
  @media (max-width: 768px) {
    .nav-links {
      display: none;
    }
  
    .nav-links-mobile {
      display: block;
      flex-direction: column;
      background-color: #1f1f1f;
      padding: 10px;
    }
  
    .menu-toggle {
      font-size: 2rem;
    }
  
    .user-info {
      flex-direction: column;
      gap: 5px;
      margin-left: 15px;
    }
  }
  </style>
  
