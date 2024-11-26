<template>
  <div>
    <!-- Navbar -->
    <plantillanavcliente :cart-item-count="carrito.length" @toggle-cart-modal="toggleCartModal"
      :userName="$page.props.auth.user.name" />
  
    <!-- Contenedor Principal -->
    <div class="container mt-3 mb-12">
      <div class="col-12 text-center">
        <h2 class="font-weight-bold mb-4" style="font-size: 2rem;">
          <em>¡Encuentra todo lo que necesitas para tu entrenamiento!</em>
        </h2>
      </div>
  
      <!-- Lista de Productos -->
      <div class="row" id="productosContainer">
        <div v-for="producto in productos" :key="producto.codProducto" class="col-md-4 mb-4">
          <div class="card position-relative">
            <div v-if="producto.stock <= 0" class="agotado-overlay">Agotado</div>
            <img
              :src="producto.imagen_url ? `/storage/uploads/${producto.imagen_url}` : 'https://via.placeholder.com/300'"
              class="card-img-top" alt="Producto">
            <div class="card-body">
              <h5><strong>Nombre:  </strong>{{ producto.nombre }}</h5>
              <p><strong>Descripción:  </strong>{{ producto.descripcion }}</p>
              <p><strong>Precio:  </strong> {{ producto.precio }} Bs.</p>
              <p><strong>Stock:  </strong> {{ producto.stock }}</p>
              <button @click="agregarAlCarrito(producto)" :disabled="producto.stock === 0"
                class="btn btn-primary btn-block mt-5">
                {{ producto.stock > 0 ? 'Agregar al carrito' : 'Sin stock' }}
              </button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Modal del Carrito -->
      <div v-if="isCartModalOpen" class="modal-overlay">
        <div class="modal-content">
          <div class="modal-header modal-title bg-danger text-white">
            <h5 class="m-0 namecar">Carrito de Compras</h5>
            <button type="button" @click="toggleCartModal" class="close text-white">&times;</button>
          </div>
          <div class="modal-body">
            <!-- Tabla de Carrito -->
            <table class="table table-bordered table-full-width">
              <thead>
                <tr>
                  <th>Nombre del Producto</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in carrito" :key="item.codProducto">
                  <td class="table-item">{{ item.nombre }}</td>
                  <td class="table-item">
                    <button @click="decrementarCantidad(item)" :disabled="item.cantidad === 1"
                      class="btn btn-sm btn-secondary ff">-</button>
                    <span class="mx-2">{{ item.cantidad }}</span>
                    <button @click="incrementarCantidad(item)" :disabled="item.cantidad >= item.stock"
                      class="btn btn-sm btn-secondary ff">+</button>
                  </td>
                  <td class="table-item">{{ item.precio * item.cantidad }} Bs.</td>
                  <td class="table-item">
                    <button @click="eliminarDelCarrito(item)" class="btn btn-sm btn-primary ">Eliminar</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="total-container text-right mt-3">
              <strong class="ee">Total:</strong> <span class="total-price">{{ totalCarrito }} Bs.</span>
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button class="btn btn-primary" @click="redirigirCompra">
              Realizar Compra
            </button>
          </div>
        </div>
      </div>
    </div>
    <VisitaFooter />
  </div>
</template>

<script>
import plantillanavcliente from '@/Layouts/plantillanavcliente.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';
import axios from 'axios';

export default {
  components: { plantillanavcliente, VisitaFooter },
  data() {
    return {
      isCartModalOpen: false,
      productos: [],
      carrito: [],
    };
  },
  computed: {
    totalCarrito() {
      return this.carrito.reduce((total, item) => total + item.precio * item.cantidad, 0);
    },
  },
  methods: {
    mostrarProductos() {
      axios.get(route('venta.obtenerProductos')).then(response => {
        this.productos = response.data;
      });
    },
    redirigirCompra() {
      const idsYCantidades = this.carrito.map(item => `${item.codProducto}:${item.cantidad}`).join(',');
      window.location.href = route('comprar.detalle', { idsYCantidades });
    },
    toggleCartModal() {
      this.isCartModalOpen = !this.isCartModalOpen;
    },
    agregarAlCarrito(producto) {
      const itemEnCarrito = this.carrito.find(i => i.codProducto === producto.codProducto);

      if (itemEnCarrito) {
        if (itemEnCarrito.cantidad < producto.stock) {
          itemEnCarrito.cantidad++;
        } else {
          alert("No hay suficiente stock para agregar más unidades.");
        }
      } else {
        this.carrito.push({
          ...producto,
          cantidad: 1,
        });
      }
      this.$forceUpdate();
    },
    incrementarCantidad(item) {
      if (item.cantidad < item.stock) {
        item.cantidad++;
      }
    },
    decrementarCantidad(item) {
      if (item.cantidad > 1) {
        item.cantidad--;
      }
    },
    eliminarDelCarrito(item) {
      this.carrito = this.carrito.filter(i => i.codProducto !== item.codProducto);
    },
  },
  mounted() {
    this.mostrarProductos();
  }
};
</script>


<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  position: relative;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
}

.modal-title h5 {
  margin: 0;
  font-size: 30px !important;
}

.namecar {
  font-weight: bold;
  font-size: 20px;
}

.table-full-width {
  width: 100%;
  margin-top: 15px;
}

.table-bordered {
  width: 100%;
}

.table-bordered th,
.table-bordered td {
  font-size: 1.1em;
  padding: 12px 20px;
  border: 1px solid #ddd !important;
}

.table-item {
  padding: 12px 20px;
  white-space: nowrap;
}

.table-item.price {
  width: 120px;
}

.ff {
  font-weight: bold;
  width: 20px;
  border-radius: 4px;
}

.close {
  font-size: 30px;
  border: none;
  font-weight: bold;
  padding: 5px;
  cursor: pointer;
  background: none;
}

.total-container {
  font-size: 1.2em;
  font-weight: bold;
}

.total-price {
  color: #333;
}

.ee {
  color: #333;
}

th,
td {
  color: #333;
}

.agotado-overlay {
  position: absolute;
  top: 10px;
  left: 10px;
  background-color: red;
  color: white;
  padding: 5px;
  border-radius: 3px;
  font-weight: bold;
}
</style>
