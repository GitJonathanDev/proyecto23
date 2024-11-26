<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Propiedades recibidas desde Inertia
const props = defineProps({
    horarios: Object, // Paginated horario data
});

// Estado para manejar la visibilidad del modal de eliminación y el horario seleccionado
const showModal = ref(false);
const selectedHorario = ref(null);

// Función para abrir el modal de confirmación de eliminación
const confirmDeleteHorario = (item) => {
    selectedHorario.value = item;
    showModal.value = true;
};

// Función para manejar la eliminación
const deleteHorario = () => {
    if (selectedHorario.value) {
        router.delete(route('horario.destroy', selectedHorario.value.codHorario), {
            onSuccess: () => {
                showModal.value = false;
            }
        });
    }
};
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name"/>
  <AppLayout title="Gestionar Horarios">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de Horarios</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Lista de Horarios</h1>

            <!-- Botones y formulario de búsqueda -->
            <div class="flex justify-between items-center mb-6">
              <!-- Nuevo horario -->
              <Link :href="route('horario.create')" class="btn btn-primary inline-flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Registrar</span>
              </Link>

              <!-- Formulario de búsqueda -->
              <form :action="route('horario.index')" method="get" class="flex space-x-2">
                <TextInput class="w-full" name="buscar" placeholder="Buscar" />
                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                  <i class="fas fa-search"></i>
                  <span>Buscar</span>
                </button>
              </form>
            </div>

            <!-- Tabla de horarios -->
            <div class="overflow-x-auto">
              <table class="table-auto w-full text-sm">
                <thead>
                  <tr>
                    <th class="p-3 text-left">Código</th>
                    <th class="p-3 text-left">Hora de Inicio</th>
                    <th class="p-3 text-left">Hora de Fin</th>
                    <th class="p-3 text-center">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in props.horarios.data" :key="item.codHorario" class="border-b">
                    <td class="p-3">{{ item.codHorario }}</td>
                    <td class="p-3">{{ item.horaInicio }}</td>
                    <td class="p-3">{{ item.horaFin }}</td>
                    <td class="p-3 text-center">
                      <!-- Editar -->
                      <Link :href="route('horario.edit', item.codHorario)" class="btn btn-warning btn-sm mx-1">
                        <i class="fas fa-edit"></i> Editar
                      </Link>

                      <!-- Eliminar -->
                      <button @click="confirmDeleteHorario(item)" class="btn btn-danger btn-sm mx-1">
                        <i class="fas fa-trash"></i> Eliminar
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Paginación -->
            <div class="flex justify-between mt-4">
              <div v-if="props.horarios?.prev_page_url">
                <Link :href="props.horarios?.prev_page_url" class="btn btn-primary">
                  <i class="fas fa-arrow-left"></i> Anterior
                </Link>
              </div>
              <div v-if="props.horarios?.next_page_url">
                <Link :href="props.horarios?.next_page_url" class="btn btn-primary">
                  Siguiente <i class="fas fa-arrow-right"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <DialogModal :show="showModal" @close="showModal = false">
      <template v-slot:title>
        <h1 class="text-lg font-semibold">Confirmar Eliminación</h1>
      </template>
      <template v-slot:content>
        <p>¿Estás seguro de que deseas eliminar el horario con código <strong>{{ selectedHorario?.codHorario }}</strong>?</p>
      </template>
      <template v-slot:footer>
        <PrimaryButton @click="deleteHorario" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
        <button @click="showModal = false" class="ml-4 btn btn-secondary">Cancelar</button>
      </template>
    </DialogModal>
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
.py-12 {
  margin-top: calc(60px + 1rem); 
}
</style>
