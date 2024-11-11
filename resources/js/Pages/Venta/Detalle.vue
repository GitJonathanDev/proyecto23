<template>
    <div>
      
      <plantillanav />
      <div class="p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Detalles de la Venta</h2>
  
        <div class="mb-6">
          <h3 class="text-xl font-semibold text-gray-700">Venta #{{ venta.codVenta }}</h3>
          <p class="text-gray-600"><strong>Fecha de Venta:</strong> {{ venta.fechaVenta }}</p>
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
                <td class="px-4 py-2 text-gray-800">{{ producto.nombre }}</td>
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
      </div>
    </div>
  </template>
  
  <script>
  // Importamos el componente plantillanav
  import plantillanav from '@/Layouts/plantillanav.vue';
  
  export default {
    props: {
      venta: Object,
      detalleVenta: Array,
      pago: Object,
      producto: Object
    },
    components: {
      plantillanav
    }
  }
  </script>
  
  <style scoped>

  </style>
  