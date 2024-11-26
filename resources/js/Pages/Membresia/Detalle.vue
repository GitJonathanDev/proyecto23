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
              <th class="px-4 py-3">Fecha Inicio</th>
              <th class="px-4 py-3">Fecha Fin</th>
              <th class="px-4 py-3">Subtotal</th>
              <th class="px-4 py-3">Horario</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="detalle in detalleMembresia" :key="detalle.id" class="border-b hover:bg-gray-50">
              <td class="px-4 py-3 text-gray-700">{{ detalle.servicio.nombre }}</td>
              <td class="px-4 py-3 text-gray-500">{{ detalle.servicio.descripcion }}</td>
              <td class="px-4 py-3 text-gray-600">{{ formatoFecha(detalle.fechaInicio) }}</td> <!-- Mostrar Fecha Inicio con formato -->
              <td class="px-4 py-3 text-gray-600">{{ formatoFecha(detalle.fechaFin) }}</td> <!-- Mostrar Fecha Fin con formato -->
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

    <!-- Botones para realizar acciones -->
    <div class="mt-6 flex justify-between space-x-4">
      <!-- Botón Realizar Nueva Venta de Membresía -->
      <Link :href="route('membresia.create')" class="btn btn-primary me-3">
        <i class="fas fa-plus"></i> Realizar Nueva Venta de Membresía
      </Link>
      
      <!-- Botón Volver -->
      <Link :href="route('membresia.index')" class="btn btn-secondary me-3">
        <i class="fas fa-arrow-left"></i> Atrás
      </Link>
    </div>
  </div>
</template>

<script>
// Asegúrate de importar el componente `Link` de Inertia.js
import { Link } from '@inertiajs/inertia-vue3';

export default {
  components: {
    // Registra el componente Link
    Link
  },
  props: {
    // Se reciben los datos desde el controlador de Laravel
    detalleMembresia: Array
  },
  methods: {
    // Formatear las fechas con el formato deseado y ajustar zona horaria
    formatoFecha(fecha) {
      const date = new Date(fecha); // Convertir la fecha UTC a objeto Date
      const fechaLocal = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate());
      // Usar `toLocaleDateString` para mostrar la fecha de acuerdo a la zona horaria local
      const options = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
      };
      return fechaLocal.toLocaleDateString('es-ES', options); // Retorna la fecha en formato dd/mm/yyyy
    },

    // Método para formatear el precio
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
/* Estilos adicionales para los botones */
.btn {
  display: inline-flex;
  align-items: center;
  padding: 8px 16px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 4px;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.btn-primary {
  background-color: #6366f1;
  color: white;
}

.btn-primary:hover {
  background-color: #4f46e5;
}

.btn-secondary {
  background-color: #6b7280;
  color: white;
}

.btn-secondary:hover {
  background-color: #4b5563;
}

.btn i {
  margin-right: 8px;
}
</style>
