<template>
    <div>
      <!-- Navbar -->
      <plantillanavcliente />
      <div class="container mt-3">
        <h2 class="text-center mb-4">¡Encuentra todo lo que necesitas para tu entrenamiento!</h2>
        <div class="mb-4">
          <select v-model="selectedCategory" class="custom-select" @change="filtrarProductos">
            <option value="">Todas las categorías</option>
            <option v-for="categoria in categorias" :key="categoria.codCategoria" :value="categoria.codCategoria">
              {{ categoria.nombre }}
            </option>
          </select>
        </div>
  
        <!-- Lista de Productos en tres columnas -->
        <div class="row" id="productosContainer">
          <div v-for="producto in productosFiltrados" :key="producto.codProducto" class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card">
              <div v-if="producto.stock <= 0" class="agotado-overlay">Agotado</div>
              <img :src="producto.imagen_url" class="card-img-top" alt="Producto">
              <div class="card-body">
                <h5>{{ producto.nombre }}</h5>
                <p>{{ producto.descripcion }}</p>
                <p><strong>Precio:</strong> {{ producto.precio }} Bs.</p>
                <button @click="agregarAlCarrito(producto)" class="btn btn-primary btn-block">Agregar al carrito</button>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Modal del Carrito -->
        <div v-if="isCartModalOpen" class="modal fade show d-block" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5>Carrito de Compras</h5>
                <button type="button" @click="isCartModalOpen = false" class="close">&times;</button>
              </div>
              <div class="modal-body">
                <ul>
                  <li v-for="item in carrito" :key="item.codProducto">{{ item.nombre }} x{{ item.cantidad }} - {{ item.precio }} Bs.</li>
                </ul>
                <p>Total: {{ totalCarrito }} Bs.</p>
              </div>
              <div class="modal-footer">
                <button @click="isCartModalOpen = false" class="btn btn-secondary">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import plantillanavcliente from '@/Layouts/plantillanavcliente.vue';
  
  export default {
    components: {
      plantillanavcliente,
    },
    data() {
      return {
        selectedCategory: "",
        isCartModalOpen: false,
        productos: [
          { codProducto: 1, nombre: "Proteína Whey", descripcion: "Suplemento para ganar masa muscular.", precio: 250, stock: 10, imagen_url: "https://via.placeholder.com/300", codCategoria: 1 },
          { codProducto: 2, nombre: "Creatina", descripcion: "Mejora el rendimiento en fuerza.", precio: 150, stock: 5, imagen_url: "https://via.placeholder.com/300", codCategoria: 1 },
          { codProducto: 3, nombre: "Bebida Energética", descripcion: "Energía inmediata.", precio: 20, stock: 15, imagen_url: "https://via.placeholder.com/300", codCategoria: 2 },
        ],
        categorias: [
          { codCategoria: 1, nombre: "Suplementos" },
          { codCategoria: 2, nombre: "Bebidas Energéticas" },
        ],
        carrito: [],
      };
    },
    computed: {
      productosFiltrados() {
        return this.selectedCategory
          ? this.productos.filter(p => p.codCategoria === parseInt(this.selectedCategory))
          : this.productos;
      },
      totalCarrito() {
        return this.carrito.reduce((total, item) => total + item.precio * item.cantidad, 0);
      },
    },
    methods: {
      filtrarProductos() {
        // Filtrado gestionado en computed `productosFiltrados`
      },
      agregarAlCarrito(producto) {
        const item = this.carrito.find(i => i.codProducto === producto.codProducto);
        if (item && item.cantidad < producto.stock) {
          item.cantidad++;
        } else if (!item) {
          this.carrito.push({ ...producto, cantidad: 1 });
        }
        this.isCartModalOpen = true;
      },
    },
  };
  </script>
  
  <style scoped>
  .agotado-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 0, 0, 0.5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    z-index: 10;
  }
  </style>