<template>
    <plantillanav />
    <AppLayout title="Realizar Venta">
      <template #header>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Realizar Venta</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Formulario de venta -->
          <form @submit.prevent="submitVenta" class="space-y-6">
            <!-- Errores -->
            <div v-if="errors.length" class="alert alert-danger bg-red-100 text-red-800 p-4 rounded-md">
              <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </div>
  
            <input type="hidden" v-model="productosSeleccionadosInput" />
            <input type="hidden" v-model="totalVentaInput" />
  
            <!-- Encargado -->
            <div class="form-group">
              <label for="encargado" class="block text-sm font-medium text-gray-700">Encargado:</label>
              <input type="hidden" v-model="codEncargadoF" />
              <p class="text-lg font-semibold">{{ encargado.nombre }} {{ encargado.apellidoPaterno }} {{ encargado.apellidoMaterno }}</p>
            </div>
  
            <!-- Cliente -->
            <div class="form-group">
              <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente:</label>
              <select v-model="codClienteF" class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option v-for="cliente in clientes" :key="cliente.carnetIdentidad" :value="cliente.carnetIdentidad">
                  {{ cliente.nombre }} - {{ cliente.apellidoPaterno }} - {{ cliente.apellidoMaterno }} - {{ cliente.telefono }}
                </option>
              </select>
            </div>
  
            <!-- Fecha de la venta -->
            <div class="form-group">
              <label for="fechaventa" class="block text-sm font-medium text-gray-700">Fecha:</label>
              <input type="date" v-model="fechaVenta" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required />
            </div>
  
            <!-- Botones -->
            <div class="flex space-x-4">
              <button type="button" class="btn btn-primary mb-3 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600" @click="openBuscarProductoModal">
                <i class="fas fa-search"></i> Buscar Producto
              </button>
              <button type="submit" class="btn btn-primary mb-3 bg-green-500 text-white p-2 rounded-md hover:bg-green-600" :disabled="productosSeleccionados.length === 0">
                Realizar Venta
              </button>
            </div>
  
            <!-- Detalle de la venta -->
            <div v-if="venta">
              <a :href="route('venta.show', venta.codVenta)" class="btn btn-info mb-3 bg-teal-500 text-white p-2 rounded-md hover:bg-teal-600">
                Ver Detalle de Venta
              </a>
            </div>
  
            <a :href="route('venta.index')" class="btn btn-secondary mb-3 bg-gray-500 text-white p-2 rounded-md hover:bg-gray-600">
              <i class="fas fa-arrow-left"></i> Volver
            </a>
          </form>
  
          <!-- Modal de búsqueda de productos -->
          <DialogModal :show="showBuscarProductoModal">
            <template #title>
              <h5 class="modal-title text-xl font-semibold text-gray-800">Buscar Producto</h5>
            </template>
            <template #content>
              <div class="form-group mb-4">
                <label for="nombreProducto" class="block text-sm font-medium text-gray-700">Buscar por Nombre:</label>
                <input
                  type="text"
                  v-model="nombreProducto"
                  class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Ingrese el nombre del producto"
                />
              </div>
  
              <div class="table-responsive overflow-x-auto">
                <table class="table table-striped w-full text-sm">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="py-2 px-4 text-left">Nombre</th>
                      <th class="py-2 px-4 text-left">Precio</th>
                      <th class="py-2 px-4 text-left">Stock</th>
                      <th class="py-2 px-4 text-left">Categoría</th>
                      <th class="py-2 px-4 text-left">Imagen</th>
                      <th class="py-2 px-4 text-left">Opción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="producto in productos" :key="producto.codProducto">
                      <td class="py-2 px-4">{{ producto.nombre }}</td>
                      <td class="py-2 px-4">{{ producto.precio }} Bs.</td>
                      <td class="py-2 px-4">{{ producto.stock }}</td>
                      <td class="py-2 px-4">{{ producto.categoria ? producto.categoria.nombre : 'Sin categoría' }}</td>
                      <td class="py-2 px-4">
                        <img
                          v-if="producto.imagen_url"
                          :src="`/storage/uploads/${producto.imagen_url}`"
                          alt="Imagen del producto"
                          class="img-thumbnail w-24 h-24 object-cover"
                        />
                        <span v-else>No tiene imagen</span>
                      </td>
                      <td class="py-2 px-4">
                        <button
                          type="button"
                          class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600"
                          @click="seleccionarProducto(producto)"
                        >
                          Seleccionar
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </template>
            <template #footer>
              <button type="button" class="btn btn-secondary bg-gray-500 text-white p-2 rounded-md hover:bg-gray-600" @click="showBuscarProductoModal = false">
                Cerrar
              </button>
            </template>
          </DialogModal>
  
          <!-- Productos seleccionados -->
          <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800">Productos Seleccionados</h3>
            <table class="table table-striped w-full text-sm mt-4">
              <thead class="bg-gray-100">
                <tr>
                  <th class="py-2 px-4 text-left">Nombre</th>
                  <th class="py-2 px-4 text-left">Cantidad</th>
                  <th class="py-2 px-4 text-left">Precio</th>
                  <th class="py-2 px-4 text-left">Subtotal</th>
                  <th class="py-2 px-4 text-left">Acción</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="producto in productosSeleccionados" :key="producto.id">
                  <td class="py-2 px-4">{{ producto.nombre }}</td>
                  <td class="py-2 px-4">
                    <input
                      type="number"
                      v-model="producto.cantidad"
                      min="1"
                      class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                      @input="calcularTotalVenta"
                    />
                  </td>
                  <td class="py-2 px-4">{{ producto.precio }} Bs.</td>
                  <td class="py-2 px-4">{{ (producto.cantidad * producto.precio).toFixed(2) }} Bs.</td>
                  <td class="py-2 px-4">
                    <button
                      type="button"
                      class="bg-red-500 text-white p-2 rounded-md hover:bg-red-600"
                      @click="quitarProducto(producto.id)"
                    >
                      <i class="fas fa-times"></i> Quitar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
  
          <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800">Total de la Venta</h3>
            <p class="text-xl font-bold text-green-600">{{ totalVenta.toFixed(2) }} Bs.</p>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import { ref, computed, watch } from 'vue';
  import { router, usePage } from '@inertiajs/vue3';
  import DialogModal from '@/Components/DialogModal.vue';
  import plantillanav from '@/Layouts/plantillanav.vue';
  
  const { props } = usePage();
  const encargado = props.encargado;
  const clientes = props.clientes;
  const productos = ref(props.productos || []);
  const venta = props.venta || null;
  
  const showBuscarProductoModal = ref(false);
  const nombreProducto = ref('');
  const productosSeleccionados = ref([]);
  const totalVenta = ref(0);
  
  const codEncargadoF = ref(encargado ? encargado.carnetIdentidad : '');
  const codClienteF = ref('');
  const fechaVenta = ref(new Date().toISOString().split('T')[0]);
  
  const productosSeleccionadosInput = computed(() => JSON.stringify(productosSeleccionados.value));
  const totalVentaInput = computed(() => totalVenta.value.toFixed(2));
  
  const errors = ref([]);
  
  const seleccionarProducto = (producto) => {
    const productoExistente = productosSeleccionados.value.find((p) => p.id === producto.codProducto);
    if (productoExistente) {
      productoExistente.cantidad++;
    } else {
      productosSeleccionados.value.push({
        id: producto.codProducto,
        nombre: producto.nombre,
        precio: producto.precio,
        cantidad: 1,
      });
    }
    calcularTotalVenta();
  };
  
  const calcularTotalVenta = () => {
    totalVenta.value = productosSeleccionados.value.reduce((total, producto) => {
      return total + producto.cantidad * producto.precio;
    }, 0);
  };
  
  const quitarProducto = (productoId) => {
    productosSeleccionados.value = productosSeleccionados.value.filter((p) => p.id !== productoId);
    calcularTotalVenta();
  };
  
  const submitVenta = () => {
    const data = {
      codEncargadoF: codEncargadoF.value,
      codClienteF: codClienteF.value,
      fechaVenta: fechaVenta.value,
      productosSeleccionados: productosSeleccionadosInput.value,
      totalVenta: totalVentaInput.value,
    };
  
    axios.post(route('venta.store'), data)
      .then(() => {
        router.get(route('venta.index'));
      })
      .catch((error) => {
        if (error.response) {
          // Si la respuesta está definida, accedemos a los errores
          errors.value = error.response.data.errors || [];
        } else {
          // Si no hay respuesta, es un error de red u otro tipo
          console.error('Error de red o problema con el servidor:', error);
          errors.value = ['Hubo un error al procesar la solicitud. Inténtalo más tarde.'];
        }
      });
  };
  
  const openBuscarProductoModal = () => {
    showBuscarProductoModal.value = true;
  };
  
  watch(productosSeleccionados, calcularTotalVenta, { deep: true });
  </script>
  
  <style scoped>
  .py-12 {
    margin-top: calc(60px + 1rem); 
  }
  </style>
  