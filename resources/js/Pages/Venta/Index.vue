<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Recibimos las ventas como props desde Inertia
const { ventas } = usePage().props;

// Estado para manejar el criterio de búsqueda y el texto ingresado
const criterio = ref('fechaVenta');
const buscar = ref('');

// Enviar formulario de búsqueda
const handleSearch = () => {
  // Aquí puedes configurar una búsqueda filtrada si lo necesitas
  router.get(route('venta.index'), { buscar: buscar.value, criterio: criterio.value });
};
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name"/>
  <AppLayout title="Gestionar Ventas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lista de Ventas
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Lista de Ventas</h1>

            <!-- Contenedor de los botones (Nuevo tipo de usuario y búsqueda) -->
            <div class="flex justify-between items-center mb-6">
              <!-- Registrar venta -->
              <Link :href="route('venta.create')" class="btn btn-primary inline-flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Registrar</span>
              </Link>

              <!-- Formulario de búsqueda -->
              <form @submit.prevent="handleSearch" class="flex space-x-2">
                <select v-model="criterio" class="form-select">
                  <option value="fechaVenta">Fecha</option>
                  <option value="codClienteF">ID Cliente</option>
                  <option value="codEncargadoF">ID Encargado</option>
                </select>
                <TextInput v-model="buscar" class="w-full" placeholder="Buscar Venta" />
                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                  <i class="fas fa-search"></i>
                  <span>Buscar</span>
                </button>
              </form>
            </div>

            <!-- Tabla de ventas -->
            <div class="overflow-x-auto">
              <table class="table-auto w-full text-sm">
                <thead>
                  <tr>
                    <th class="p-3 text-left">Código de Venta</th>
                    <th class="p-3 text-left">Fecha de Venta</th>
                    <th class="p-3 text-left">Monto Total</th>
                    <th class="p-3 text-left">Cliente</th>
                    <th class="p-3 text-left">Encargado</th>
                    <th class="p-3 text-center">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="venta in ventas.data" :key="venta.codVenta" class="border-b">
                    <td class="p-3">{{ venta.codVenta }}</td>
                    <td class="p-3">{{ new Date(venta.fechaVenta).toLocaleDateString() }}</td>
                    <td class="p-3">{{ venta.montoTotal.toFixed(2) }} Bs.</td>
                    <td class="p-3">{{ venta.cliente.nombre }}</td>
                    <td class="p-3">{{ venta.encargado.nombre }}</td>
                    <td class="p-3 text-center">
                      <Link :href="route('venta.show', venta.codVenta)" class="btn btn-primary btn-sm mx-1">
                        <i class="fas fa-eye"></i> Ver Detalle
                      </Link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Paginación -->
            <div class="flex justify-between mt-4">
              <div v-if="ventas.prev_page_url">
                <Link :href="ventas.prev_page_url" class="btn btn-primary">
                  <i class="fas fa-arrow-left"></i> Anterior
                </Link>
              </div>
              <div v-if="ventas.next_page_url">
                <Link :href="ventas.next_page_url" class="btn btn-primary">
                  Siguiente <i class="fas fa-arrow-right"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <VisitaFooter />
    </div>
  </AppLayout>
</template>

<style scoped>
.table-auto th, .table-auto td {
  text-align: left;
  vertical-align: middle;
}
.btn {
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
}
.btn-info:hover {
  background-color: #0EA5E9;
}
</style>
