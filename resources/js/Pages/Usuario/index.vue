<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

const props = defineProps({
    usuarios: Object // Asegúrate de que este objeto sea el formato correcto de la paginación
});

// Estado para manejar la visibilidad del modal y el usuario seleccionado
const showModal = ref(false);
const selectedUsuario = ref(null);

// Función para abrir el modal de confirmación de eliminación
const confirmDeleteUsuario = (item) => {
    selectedUsuario.value = item;
    showModal.value = true;
};

// Función para manejar la eliminación
const deleteUsuario = () => {
    if (selectedUsuario.value) {
        router.delete(route('usuario.destroy', selectedUsuario.value.codUsuario));
        showModal.value = false;
    }
};

// Estado para manejar la búsqueda
const searchTerm = ref('');
const searchCriteria = ref('');

// Función para manejar la búsqueda
const handleSearch = () => {
    const queryParams = new URLSearchParams();
    if (searchTerm.value) {
        queryParams.append('buscar', searchTerm.value);
    }
    if (searchCriteria.value) {
        queryParams.append('criterio', searchCriteria.value);
    }
    window.location.href = `${route('usuario.index')}?${queryParams.toString()}`;
};
</script>

<template>
    <plantillanav :userName="$page.props.auth.user.name"/>
    <AppLayout title="Gestionar Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6">Lista de Usuarios</h1>

                        <!-- Contenedor de los botones (Nuevo usuario y búsqueda) -->
                        <div class="flex justify-between items-center mb-6">
                            <!-- Nuevo usuario -->
                            <Link :href="route('usuario.create')" class="btn btn-primary inline-flex items-center space-x-2">
                                <i class="fas fa-user-plus"></i>
                                <span>Registrar</span>
                            </Link>

                            <!-- Formulario de búsqueda -->
                            <form @submit.prevent="handleSearch" class="flex space-x-2">
                                <select v-model="searchCriteria" class="form-select">
                                    <option value="" disabled selected>Seleccionar criterio</option>
                                    <option value="name">Nombre</option> <!-- Cambié "nombreUsuario" por "name" -->
                                    <option value="codTipoUsuarioF">Tipo de Usuario</option>
                                </select>
                                <TextInput v-model="searchTerm" class="w-full" placeholder="Buscar usuario" />
                                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                                    <i class="fas fa-search"></i>
                                    <span>Buscar</span>
                                </button>
                            </form>
                        </div>

                        <!-- Tabla de usuarios -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="p-3 text-left">Código de Usuario</th>
                                        <th class="p-3 text-left">Nombre</th>
                                        <th class="p-3 text-left">Email</th>
                                        <th class="p-3 text-left">Contraseña</th>
                                        <th class="p-3 text-left">Tipo de Usuario</th>
                                        <th class="p-3 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="usuario in usuarios.data" :key="usuario.codUsuario" class="border-b">
                                        <td class="p-3">{{ usuario.codUsuario }}</td>
                                        <td class="p-3">{{ usuario.name }}</td>
                                        <td class="p-3">{{ usuario.email }}</td>
                                        <td class="p-3">********</td>
                                        <td class="p-3">
    <span v-if="usuario.tipoUsuario">{{ usuario.tipoUsuario.descripcion }}</span>
    <span v-else>N/A</span>
</td>

                                        <td class="p-3 text-center">
                                            <!-- Editar -->
                                            <Link :href="route('usuario.edit', usuario.codUsuario)" class="btn btn-warning btn-sm mx-1">
                                                <i class="fas fa-edit"></i> Editar
                                            </Link>

                                            <!-- Eliminar -->
                                            <button @click="confirmDeleteUsuario(usuario)" class="btn btn-danger btn-sm mx-1">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex justify-between mt-4">
                            <div v-if="usuarios?.prev_page_url">
                                <Link :href="usuarios?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="usuarios?.next_page_url">
                                <Link :href="usuarios?.next_page_url" class="btn btn-primary">
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
                <p>¿Estás seguro de que deseas eliminar el usuario <strong>{{ selectedUsuario?.name }}</strong>?</p> <!-- Cambié "nombreUsuario" por "name" -->
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteUsuario" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
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
    margin-top: calc(10px + 1rem); 
}
</style>
