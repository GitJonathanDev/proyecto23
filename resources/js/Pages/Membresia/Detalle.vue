<template>
    <div class="container mx-auto p-6">
      <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Detalle de la Venta de Membresía</h1>
  
      <!-- Verifica si los detalles de la membresía están disponibles -->
      <div v-if="detalleMembresia.length > 0">
        <!-- Total Precio Membresía -->
        <div class="mb-6">
          <h5 class="text-xl font-semibold text-gray-700">Total Precio Membresía:
            <span class="text-2xl font-bold text-indigo-600">{{ formatCurrency(detalleMembresia[0].membresia.precioTotal) }} Bs.</span>
          </h5>
        </div>
  
        <!-- Servicios adquiridos -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
          <h3 class="text-2xl font-semibold text-gray-800 p-4 border-b">Servicios Adquiridos</h3>
          <table class="min-w-full bg-white">
            <thead class="bg-gray-100 text-gray-600 text-left">
              <tr>
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Descripción</th>
                <th class="px-4 py-3">Fecha fin</th>
                <th class="px-4 py-3">Subtotal</th>
                <th class="px-4 py-3">Horario</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="detalle in detalleMembresia" :key="detalle.id" class="border-b hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-700">{{ detalle.servicio.nombre }}</td>
                <td class="px-4 py-3 text-gray-500">{{ detalle.servicio.descripcion }}</td>
                <td class="px-4 py-3 text-gray-600">{{ formatDate(detalle.fechaFin) }}</td>
                <td class="px-4 py-3 text-indigo-600">{{ formatCurrency(detalle.subTotal) }} Bs.</td>
                <td class="px-4 py-3 text-gray-600">
                  <div><strong>Hora Inicio:</strong> {{ detalle.servicio.horario.horaInicio }}</div>
                  <div><strong>Hora Fin:</strong> {{ detalle.servicio.horario.horaFin }}</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div v-else class="text-center text-gray-500 mt-8">
        <p>No se encontraron detalles de membresía.</p>
      </div>
      <div class="mt-6 flex justify-between space-x-4">
        <inertia-link href="/membresia/create" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out">
          Realizar Nueva Venta de Membresía
        </inertia-link>
        <inertia-link href="/membresia/index" class="px-6 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition duration-300 ease-in-out">
          Volver
        </inertia-link>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      // Se reciben los datos desde el controlador de Laravel
      detalleMembresia: Array
    },
    methods: {
      // Función para formatear la fecha
      formatDate(date) {
        return new Date(date).toLocaleDateString('es-BO');
      },
      // Función para formatear la moneda
      formatCurrency(amount) {
        return new Intl.NumberFormat('es-BO', {
          style: 'currency',
          currency: 'BOB',
        }).format(amount);
      }
    }
  }
  </script>
  
  <style scoped>
  /* Agregar estilos adicionales si es necesario */
  </style>
  