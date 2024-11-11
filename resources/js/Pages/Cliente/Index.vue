<template>
  <plantillanav/>
    <AppLayout title="Gestionar Clientes">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Lista de Clientes
        </h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
              <!-- Título y contenedor de botones (Nuevo cliente y búsqueda) -->
              <h1 class="text-2xl font-bold text-center mb-6">Lista de Clientes</h1>
  
              <div class="flex justify-between items-center mb-6">
                <!-- Registrar Cliente -->
                <Link :href="route('cliente.create')" class="btn btn-primary inline-flex items-center space-x-2">
                  <i class="fas fa-plus"></i>
                  <span>Registrar</span>
                </Link>
  
                <!-- Formulario de búsqueda -->
                <form @submit.prevent="buscarCliente" class="flex space-x-2">
                  <div class="input-group">
                    <select v-model="criterio" class="form-select">
                      <option value="" disabled selected>Seleccionar criterio</option>
                      <option value="nombre">Nombre</option>
                      <option value="apellidoPaterno">Apellido Paterno</option>
                      <option value="apellidoMaterno">Apellido Materno</option>
                      <option value="carnetIdentidad">Carnet de Identidad</option>
                    </select>
                    <input v-model="buscar" type="text" class="form-control" placeholder="Buscar" aria-label="Buscar">
                    <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                      <i class="fas fa-search"></i>
                      <span>Buscar</span>
                    </button>
                  </div>
                </form>
              </div>
  
              <!-- Tabla de Clientes -->
              <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm">
                  <thead class="bg-gray-800 text-white">
                    <tr>
                      <th class="p-3 text-left">Carnet de Identidad</th>
                      <th class="p-3 text-left">Nombre</th>
                      <th class="p-3 text-left">Apellido Paterno</th>
                      <th class="p-3 text-left">Apellido Materno</th>
                      <th class="p-3 text-left">Sexo</th>
                      <th class="p-3 text-left">Edad</th>
                      <th class="p-3 text-left">Telefono</th>
                      <th class="p-3 text-center">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="cliente in clientes.data" :key="cliente.carnetIdentidad" class="border-b">
                      <td class="p-3">{{ cliente.carnetIdentidad }}</td>
                      <td class="p-3">{{ cliente.nombre }}</td>
                      <td class="p-3">{{ cliente.apellidoPaterno }}</td>
                      <td class="p-3">{{ cliente.apellidoMaterno }}</td>
                      <td class="p-3">{{ cliente.sexo }}</td>
                      <td class="p-3">{{ cliente.edad }}</td>
                      <td class="p-3">{{ cliente.telefono }}</td>
                      <td class="p-3 text-center">
                        <!-- Editar -->
                        <Link :href="route('cliente.edit', cliente.carnetIdentidad)" class="btn btn-warning btn-sm mx-1">
                          <i class="fas fa-edit"></i> Editar
                        </Link>
  
                        <!-- Eliminar -->
                        <button @click="confirmDelete(cliente)" class="btn btn-danger btn-sm mx-1">
                          <i class="fas fa-trash"></i> Eliminar
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
  
              <!-- Paginación -->
              <div class="flex justify-between mt-4">
                <div v-if="clientes.prev_page_url">
                  <Link :href="clientes.prev_page_url" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Anterior
                  </Link>
                </div>
                <div v-if="clientes.next_page_url">
                  <Link :href="clientes.next_page_url" class="btn btn-primary">
                    Siguiente <i class="fas fa-arrow-right"></i>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Modal de Confirmación de Eliminación -->
      <DialogModal :show="showModal" @close="showModal = false">
        <template v-slot:title>
          <h1 class="text-lg font-semibold">Confirmar Eliminación</h1>
        </template>
        <template v-slot:content>
          <p>¿Estás seguro de que deseas eliminar al cliente <strong>{{ selectedCliente?.nombre }}</strong>?</p>
        </template>
        <template v-slot:footer>
          <PrimaryButton @click="deleteCliente" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
          <button @click="showModal = false" class="ml-4 btn btn-secondary">Cancelar</button>
        </template>
      </DialogModal>
    </AppLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { router, Link } from '@inertiajs/vue3';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import DialogModal from '@/Components/DialogModal.vue';
  import { usePage } from '@inertiajs/vue3';
  import plantillanav from '@/Layouts/plantillanav.vue';
  
  const props = defineProps({
    clientes: Object, // Propiedad para recibir los clientes paginados
  });
  
  const showModal = ref(false); // Estado para mostrar el modal
  const selectedCliente = ref(null); // Cliente seleccionado para eliminar
  const criterio = ref(''); // Criterio de búsqueda
  const buscar = ref(''); // Término de búsqueda
  
  // Función para abrir el modal de confirmación de eliminación
  const confirmDelete = (cliente) => {
    selectedCliente.value = cliente;
    showModal.value = true;
  };
  
  // Función para manejar la eliminación del cliente
  const deleteCliente = () => {
    if (selectedCliente.value) {
      router.delete(route('cliente.destroy', selectedCliente.value.carnetIdentidad), {
        onSuccess: () => {
          showModal.value = false;
        }
      });
    }
  };
  
  // Función para manejar la búsqueda
  const buscarCliente = () => {
    router.get(route('cliente.index'), {
      criterio: criterio.value,
      buscar: buscar.value,
    });
  };
  </script>
  
  <style scoped>
  /* Estilo para la tabla y los botones */
  .table-auto th, .table-auto td {
    text-align: left;
    vertical-align: middle;
  }
  
  .table-auto th {
    background-color: #4B5563; /* Fondo gris */
    color: #fff;
  }
  
  .table-auto tr:nth-child(even) {
    background-color: #F3F4F6; /* Filas de color gris claro */
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
  
  .btn-outline-secondary {
    background-color: #F9FAFB;
    color: #4B5563;
    border: 1px solid #D1D5DB;
  }
  
  .btn-outline-secondary:hover {
    background-color: #E5E7EB;
  }
  
  .btn-primary {
    background-color: #3B82F6;
    color: white;
    border: 1px solid transparent;
  }
  
  .btn-primary:hover {
    background-color: #2563EB;
  }
  
  .btn-warning {
    background-color: #F59E0B;
    color: white;
  }
  
  .btn-warning:hover {
    background-color: #D97706;
  }
  
  .btn-danger {
    background-color: #EF4444;
    color: white;
  }
  
  .btn-danger:hover {
    background-color: #DC2626;
  }
  
  .btn-secondary {
    background-color: #E5E7EB;
    color: #1F2937;
  }
  
  .btn-secondary:hover {
    background-color: #D1D5DB;
  }
  .py-12 {
  margin-top: calc(60px + 1rem); 
}
  </style>
  