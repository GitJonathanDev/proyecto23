<template>
  <plantillanav :userName="$page.props.auth.user.name"/>
  <AppLayout title="Realizar Compra">
    <template #header>
      <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Realizar Compra</h2>
    </template>
    <div class="divgrande rounded-2xl mb-12" >
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submitCompra" class="space-y-6">
          <!-- Errores -->
          <div v-if="errors.length" class="alert alert-danger bg-red-100 text-red-800 p-4 rounded-md">
            <ul>
              <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
          </div>

          <input type="hidden" v-model="productosSeleccionadosInput" />
          <input type="hidden" v-model="totalCompraInput" />

          <div class="form-group">
            <label for="encargado" class="block text-sm font-medium text-gray-700 bb">Encargado:</label>
            <input type="hidden" v-model="codEncargadoF" />
            <p class="text-lg font-semibold">{{ encargado.nombre }} {{ encargado.apellidoPaterno }} {{ encargado.apellidoMaterno }}</p>
          </div>

          <div class="form-group">
            <label for="proveedor" class="block text-sm font-medium text-gray-700 bb">Proveedor:</label>
            <select v-model="codProveedorF" class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 cc" required>
              <option v-for="proveedor in proveedores" :key="proveedor.codProveedor" :value="proveedor.codProveedor">
                {{ proveedor.nombre }} - {{ proveedor.direccion }} - {{ proveedor.telefono }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="fechacompra" class="block text-sm font-medium text-gray-700 bb">Fecha:</label>
            <input type="date" v-model="fechaCompra" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 cc" required />
          </div>
          <div class="flex space-x-4">
            <button type="button" class="btn btn-primary mb-3 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600" @click="openBuscarProductoModal">
              <i class="fas fa-search"></i> Buscar Producto
            </button>
            <button type="submit" class="btn btn-primary mb-3 bg-green-500 text-white p-2 rounded-md hover:bg-green-600" :disabled="productosSeleccionados.length === 0">
              Realizar Compra
            </button>
          </div>

          <!-- Detalle de compra -->
          <div v-if="compra">
            <a :href="route('compra.show', compra.codCompra)" class="btn btn-info mb-3 bg-teal-500 text-white p-2 rounded-md hover:bg-teal-600">
              Ver Detalle de Compra
            </a>
          </div>

          <a :href="route('compra.index')" class="btn btn-secondary mb-3 bg-gray-500 text-white p-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-arrow-left mt-5"></i> Volver
          </a>
        </form>

        <!-- Modal de búsqueda de productos -->
        <DialogModal :show="showBuscarProductoModal">
          <template #title>
            <h5 class="modal-title cc text-xl font-semibold text-gray-800 bb">Buscar Producto</h5>
          </template>
          <template #content>
            <div class="form-group mb-4">
              <label for="nombreProducto" class="block cc text-sm font-medium text-gray-700 bb">Buscar por Nombre:</label>
              <input
                type="text"
                v-model="nombreProducto"
                class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Ingrese el nombre del producto"
              />
            </div>

            <div class="overflow-x-auto mt-4">
  <table class="table-auto w-full text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-3 text-left">Nombre</th>
        <th class="p-3 text-left">Precio</th>
        <th class="p-3 text-left">Stock</th>
        <th class="p-3 text-left">Categoría</th>
        <th class="p-3 text-left">Imagen</th>
        <th class="p-3 text-center">Opción</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="producto in productos" :key="producto.codProducto" class="border-b">
        <td class="p-3">{{ producto.nombre }}</td>
        <td class="p-3">{{ producto.precio }} Bs.</td>
        <td class="p-3">{{ producto.stock }}</td>
        <td class="p-3">{{ producto.categoria?.nombre ?? 'No disponible' }}</td>
        <td class="p-3">
          <img
            v-if="producto.imagen_url"
            :src="`/storage/uploads/${producto.imagen_url}`"
            alt="Imagen del producto"
            class="img-thumbnail w-24 h-24 object-cover"
          />
          <span v-else>No tiene imagen</span>
        </td>
        <td class="p-3 text-center">
          <button
            type="button"
            class="btn-primary text-white p-2 rounded-md "
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
            <button type="button" class="btn btn-primary bg-gray-500 text-white p-2 rounded-md hover:bg-gray-600" @click="showBuscarProductoModal = false">
              Cerrar
            </button>
          </template>
        </DialogModal>

        <!-- Productos seleccionados -->
<div class="mt-6">
  <h3 class="text-lg font-semibold text-gray-800 bb">Productos Seleccionados</h3>
  <div class="overflow-x-auto mt-4">
    <table class="table-auto w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Nombre</th>
          <th class="p-3 text-left">Cantidad</th>
          <th class="p-3 text-left">Precio</th>
          <th class="p-3 text-left">Subtotal</th>
          <th class="p-3 text-center">Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productosSeleccionados" :key="producto.id" class="border-b">
          <td class="p-3">{{ producto.nombre }}</td>
          <td class="p-3">
            <input
              type="number"
              v-model="producto.cantidad"
              min="1"
              class="form-input w-full cc p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              @input="calcularTotalCompra"
            />
          </td>
          <td class="p-3">{{ producto.precio }} Bs.</td>
          <td class="p-3">{{ (producto.cantidad * producto.precio).toFixed(2) }} Bs.</td>
          <td class="p-3 text-center">
            <button
              type="button"
              class="btn-primary text-white p-2 rounded-md "
              @click="quitarProducto(producto.id)"
            >
              <i class="fas fa-times"></i> Quitar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


        <div class="mt-6 border-solid">
          <h3 class="text-lg font-semibold text-gray-800 bb">Total de la Compra</h3>
          <p class="text-2xl font-bold bb pp">{{ totalCompra.toFixed(2) }} Bs.</p>
        </div>
      </div>
    </div>
    <VisitaFooter />
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import DialogModal from '@/Components/DialogModal.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

const { props } = usePage();
const encargado = props.encargado;
const proveedores = props.proveedores;
const productos = ref(props.productos || []);
const compra = props.compra || null;

const showBuscarProductoModal = ref(false);
const nombreProducto = ref('');
const productosSeleccionados = ref([]);
const totalCompra = ref(0);

const codEncargadoF = ref(encargado ? encargado.carnetIdentidad : '');
const codProveedorF = ref('');
const fechaCompra = ref(new Date().toISOString().split('T')[0]);

const productosSeleccionadosInput = computed(() => JSON.stringify(productosSeleccionados.value));
const totalCompraInput = computed(() => totalCompra.value.toFixed(2));

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
  calcularTotalCompra();
};

const calcularTotalCompra = () => {
  totalCompra.value = productosSeleccionados.value.reduce((total, producto) => {
    return total + producto.cantidad * producto.precio;
  }, 0);
};

const quitarProducto = (productoId) => {
  productosSeleccionados.value = productosSeleccionados.value.filter((p) => p.id !== productoId);
  calcularTotalCompra();
};

const submitCompra = () => {
  const data = {
    codEncargadoF: codEncargadoF.value,
    codProveedorF: codProveedorF.value,
    fechaCompra: fechaCompra.value,
    productosSeleccionados: productosSeleccionadosInput.value,
    totalCompra: totalCompraInput.value,
  };

  axios.post(route('compra.store'), data)
    .then(() => {
      router.get(route('compra.index'));
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

watch(productosSeleccionados, calcularTotalCompra, { deep: true });
</script>
<style scoped>
.py-12 {
  margin-top: calc(60px + 1rem); 
}
.pp{
  font-size: 40px;
}
</style>