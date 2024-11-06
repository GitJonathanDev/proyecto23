<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  vendedores: Object
});

// Estado para manejar la visibilidad del modal y el vendedor seleccionado para eliminar
const showModal = ref(false);
const selectedVendedor = ref(null);

// Función para abrir el modal de confirmación de eliminación
const confirmDeleteVendedor = (item) => {
  selectedVendedor.value = item;
  showModal.value = true;
};

// Función para manejar la eliminación de un vendedor
const deleteVendedor = () => {
  if (selectedVendedor.value) {
    router.delete(route('vendedor.destroy', selectedVendedor.value.carnetIdentidad));
    showModal.value = false;
  }
};
</script>

<template>
  <AppLayout title="Lista de Encargados">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lista de Encargados
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold text-center mb-6">Lista de Encargados</h1>

            <!-- Contenedor de los botones (Nuevo encargado y búsqueda) -->
            <div class="flex justify-between items-center mb-6">
              <!-- Registrar nuevo encargado -->
              <Link :href="route('encargado.create')" class="btn btn-primary inline-flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Registrar</span>
              </Link>

              <!-- Formulario de búsqueda -->
              <form :action="route('encargado.index')" method="get" class="flex space-x-2">
                <TextInput class="w-full" name="buscar" placeholder="Buscar vendedor" />
                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                  <i class="fas fa-search"></i>
                  <span>Buscar</span>
                </button>
              </form>
            </div>

            <!-- Tabla de vendedores -->
            <div class="overflow-x-auto">
              <table class="table-auto w-full text-sm">
                <thead class="bg-gray-800 text-white">
                  <tr>
                    <th class="p-3 text-left">Carnet de Identidad</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Apellido Paterno</th>
                    <th class="p-3 text-left">Apellido Materno</th>
                    <th class="p-3 text-left">Sexo</th>
                    <th class="p-3 text-left">Teléfono</th>
                    <th class="p-3 text-left">Usuario</th>
                    <th class="p-3 text-center">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in vendedores.data" :key="item.carnetIdentidad" class="border-b">
                    <td class="p-3">{{ item.carnetIdentidad }}</td>
                    <td class="p-3">{{ item.nombre }}</td>
                    <td class="p-3">{{ item.apellidoPaterno }}</td>
                    <td class="p-3">{{ item.apellidoMaterno }}</td>
                    <td class="p-3">{{ item.sexo }}</td>
                    <td class="p-3">{{ item.telefono }}</td>
                    <td class="p-3">{{ item.usuario ? item.usuario.nombreUsuario : 'N/A' }}</td>
                    <td class="p-3 text-center">
                      <!-- Editar -->
                      <Link :href="route('encargado.edit', item.carnetIdentidad)" class="btn btn-warning btn-sm mx-1">
                        <i class="fas fa-edit"></i> Editar
                      </Link>

                      <!-- Eliminar -->
                      <button @click="confirmDeleteVendedor(item)" class="btn btn-danger btn-sm mx-1">
                        <i class="fas fa-trash"></i> Eliminar
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Paginación -->
            <div class="flex justify-between mt-4">
              <div v-if="vendedores?.prev_page_url">
                <Link :href="vendedores?.prev_page_url" class="btn btn-primary">
                  <i class="fas fa-arrow-left"></i> Anterior
                </Link>
              </div>
              <div v-if="vendedores?.next_page_url">
                <Link :href="vendedores?.next_page_url" class="btn btn-primary">
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
        <p>¿Estás seguro de que deseas eliminar el encargado <strong>{{ selectedVendedor?.nombre }} {{ selectedVendedor?.apellidoPaterno }}</strong>?</p>
      </template>
      <template v-slot:footer>
        <PrimaryButton @click="deleteVendedor" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
        <button @click="showModal = false" class="ml-4 btn btn-secondary">Cancelar</button>
      </template>
    </DialogModal>
  </AppLayout>
</template>
