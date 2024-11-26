<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Propiedades recibidas desde Inertia
const props = defineProps({
    proveedores: Object,
    permisos: {
        type: Array,
        default: () => [],
    },
});

// Estado para manejar la visibilidad del modal y el proveedor seleccionado
const showModal = ref(false);
const selectedProveedor = ref(null);

// Función para abrir el modal de confirmación de eliminación
const confirmDeleteProveedor = (item) => {
    selectedProveedor.value = item;
    showModal.value = true;
};

// Función para manejar la eliminación
const deleteProveedor = () => {
    if (selectedProveedor.value) {
        router.delete(route('proveedor.destroy', selectedProveedor.value.codProveedor));
        showModal.value = false;
    }
};
</script>

<template>
    <plantillanav :userName="$page.props.auth.user.name"/>
    <AppLayout title="Gestionar Proveedores">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Proveedores
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6">Lista de Proveedores</h1>

                        <!-- Contenedor de los botones (Nuevo proveedor y búsqueda) -->
                        <div class="flex justify-between items-center mb-6">
                            <!-- Nuevo proveedor -->
                            <Link 
    v-if="Array.isArray(permisos) && permisos.includes('registrar')" 
    :href="route('proveedor.create')" 
    class="btn btn-primary inline-flex items-center space-x-2"
>
    <i class="fas fa-plus"></i>
    <span>Registrar</span>
</Link>
<p v-if="!Array.isArray(permisos)">La propiedad permisos no es un array.</p>
<p v-if="Array.isArray(permisos) && !permisos.includes('registrar')">No tienes permiso para registrar nuevos proveedores.</p>


                            <!-- Formulario de búsqueda -->
                            <form :action="route('proveedor.index')" method="get" class="flex space-x-2">
                                <div class="flex space-x-2">
                                    <select name="criterio" class="form-select">
                                        <option value="nombre">Nombre</option>
                                        <option value="direccion">Dirección</option>
                                        <option value="telefono">Teléfono</option>
                                    </select>
                                    <TextInput class="w-full" name="buscar" placeholder="Buscar proveedor" />
                                    <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                                        <i class="fas fa-search"></i>
                                        <span>Buscar</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tabla de proveedores -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="p-3 text-left">Código</th>
                                        <th class="p-3 text-left">Nombre</th>
                                        <th class="p-3 text-left">Dirección</th>
                                        <th class="p-3 text-left">Teléfono</th>
                                        <th class="p-3 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in proveedores.data" :key="item.codProveedor" class="border-b">
                                        <td class="p-3">{{ item.codProveedor }}</td>
                                        <td class="p-3">{{ item.nombre }}</td>
                                        <td class="p-3">{{ item.direccion }}</td>
                                        <td class="p-3">{{ item.telefono }}</td>
                                        <td class="p-3 text-center">
                                            <!-- Editar -->
                                            <Link 
                                                v-if="Array.isArray(permisos) && permisos.includes('editar')" 
                                                :href="route('proveedor.edit', item.codProveedor)" 
                                                class="btn btn-warning btn-sm mx-1"
                                            >
                                                <i class="fas fa-edit"></i> Editar
                                            </Link>

                                            <!-- Eliminar -->
                                            <button 
                                                v-if="Array.isArray(permisos) && permisos.includes('eliminar')" 
                                                @click="confirmDeleteProveedor(item)" 
                                                class="btn btn-danger btn-sm mx-1"
                                            >
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex justify-between mt-4">
                            <div v-if="proveedores?.prev_page_url">
                                <Link :href="proveedores?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="proveedores?.next_page_url">
                                <Link :href="proveedores?.next_page_url" class="btn btn-primary">
                                    Siguiente <i class="fas fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <VisitaFooter />
        </div>

        <!-- Modal de confirmación de eliminación -->
        <DialogModal :show="showModal" @close="showModal = false">
            <template v-slot:title>
                <h1 class="text-lg font-semibold">Confirmar Eliminación</h1>
            </template>
            <template v-slot:content>
                <p>¿Estás seguro de que deseas eliminar el proveedor <strong>{{ selectedProveedor?.nombre }}</strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteProveedor" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
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
