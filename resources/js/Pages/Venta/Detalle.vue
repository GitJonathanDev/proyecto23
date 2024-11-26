<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <div>
    <div class="p-6 bg-white shadow-md rounded-lg">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Detalles de la Venta</h2>

      <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-700">Venta #{{ venta.codVenta }}</h3>
        <p class="text-gray-600"><strong>Fecha de Venta:</strong> {{ formatDate(venta.fechaVenta) }}</p>
        <p class="text-gray-600"><strong>Cliente:</strong> {{ venta.cliente.nombre }} {{ venta.cliente.apellidoPaterno }} {{ venta.cliente.apellidoMaterno }}</p>
        <p class="text-gray-600"><strong>Encargado:</strong> {{ venta.encargado.nombre }} {{ venta.encargado.apellidoPaterno }} {{ venta.encargado.apellidoMaterno }}</p>
        <p class="text-gray-600"><strong>Monto Total:</strong> {{ venta.montoTotal }} Bs.</p>
      </div>

      <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Productos Vendidos</h3>
        <table class="min-w-full table-auto bg-gray-100 border-collapse rounded-lg overflow-hidden">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2 text-left text-gray-700">Producto</th>
              <th class="px-4 py-2 text-left text-gray-700">Cantidad</th>
              <th class="px-4 py-2 text-left text-gray-700">Precio</th>
              <th class="px-4 py-2 text-left text-gray-700">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="producto in detalleVenta" :key="producto.codProducto" class="border-t border-gray-200">
              <td class="px-4 py-2 text-gray-800">{{ producto.producto ? producto.producto.nombre : 'Producto no disponible' }}</td>
              <td class="px-4 py-2 text-gray-800">{{ producto.cantidad }}</td>
              <td class="px-4 py-2 text-gray-800">{{ producto.precioV }} Bs.</td>
              <td class="px-4 py-2 text-gray-800">{{ (producto.cantidad * producto.precioV).toFixed(2) }} Bs.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Pago</h3>
        <p class="text-gray-600"><strong>Monto Pagado:</strong> {{ pago.monto }} Bs.</p>
        <p class="text-gray-600"><strong>Estado:</strong> {{ pago.estado }}</p>
      </div>

      <!-- Botones de navegación -->
      <div class="mt-6 flex justify-between space-x-4">
        <!-- Botón para Volver a la lista de ventas -->
        <Link :href="route('venta.index')" class="px-6 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
          Volver a la lista de ventas
        </Link>

        <!-- Botón para Realizar una nueva venta -->
        <Link :href="route('venta.create')" class="px-6 py-2 bg-green-500 text-white rounded-md shadow-md hover:bg-green-600 transition duration-300 ease-in-out">
          Realizar Nueva Venta
        </Link>

        <!-- Botón para Volver atrás -->
        <button @click="goBack" class="rounded-md shadow-md btn-primary transition">
          Volver Atrás
        </button>
      </div>
    </div>
    <VisitaFooter />
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';  // Importa Link de Inertia
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

export default {
  props: {
    venta: Object,
    detalleVenta: Array,
    pago: Object
  },
  components: {
    plantillanav
  },
  methods: {
    // Método para formatear las fechas
    formatDate(date) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString('es-BO', options);
    },
    // Método para volver a la página anterior
    goBack() {
      window.history.back();
    }
  }
};
</script>

<style scoped>
.btn-primary{
  margin: inherit !important;
}
</style>
