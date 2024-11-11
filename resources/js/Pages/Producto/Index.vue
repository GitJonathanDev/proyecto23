<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Propiedades recibidas desde Inertia
const props = defineProps({
    productos: Object,
    categorias: Array,
});

// Estado para manejar la visibilidad del modal y el producto seleccionado
const showModal = ref(false);
const selectedProducto = ref(null);

// Función para abrir el modal de confirmación de eliminación
const confirmDeleteProducto = (producto) => {
    selectedProducto.value = producto;
    showModal.value = true;
};

// Función para manejar la eliminación del producto
const deleteProducto = () => {
    if (selectedProducto.value) {
        router.delete(route('producto.destroy', selectedProducto.value.codProducto));
        showModal.value = false;
    }
};
</script>

<template>
    <plantillanav/>
    <AppLayout title="Gestionar Productos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Productos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-center mb-6">Lista de Productos</h1>

                        <!-- Contenedor de los botones (Nuevo producto y búsqueda) -->
                        <div class="flex justify-between items-center mb-6">
                            <!-- Nuevo producto -->
                            <Link :href="route('producto.create')" class="btn btn-primary inline-flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Registrar</span>
                            </Link>

                            <!-- Formulario de búsqueda -->
                            <form :action="route('producto.index')" method="get" class="flex space-x-2">
                                <div class="input-group">
                                    <select name="criterio" class="form-select" aria-label="Criterio de búsqueda">
                                        <option value="" disabled selected>Seleccionar criterio</option>
                                        <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" name="buscar" class="form-control" placeholder="Buscar producto" />
                                    <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                                        <i class="fas fa-search"></i>
                                        <span>Buscar</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tabla de productos -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-3 text-left">Código</th>
                                        <th class="p-3 text-left">Nombre</th>
                                        <th class="p-3 text-left">Descripción</th>
                                        <th class="p-3 text-left">Precio</th>
                                        <th class="p-3 text-left">Stock</th>
                                        <th class="p-3 text-left">Categoría</th>
                                        <th class="p-3 text-left">Imagen</th>
                                        <th class="p-3 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="producto in productos.data" :key="producto.codProducto" class="border-b">
                                        <td class="p-3">{{ producto.codProducto }}</td>
                                        <td class="p-3">{{ producto.nombre }}</td>
                                        <td class="p-3">{{ producto.descripcion }}</td>
                                        <td class="p-3">{{ producto.precio.toFixed(2) }} Bs.</td>
                                        <td class="p-3">{{ producto.stock }}</td>
                                        <td class="p-3">{{ producto.categoria?.nombre ?? 'No disponible' }}</td>
                                        <td class="p-3">
                                            <img v-if="producto.imagen_url" :src="`/storage/uploads/${producto.imagen_url}`" alt="Imagen del producto" class="img-thumbnail" style="max-width: 120px;" />
                                            <span v-else>No tiene imagen</span>
                                        </td>
                                        <td class="p-3 text-center">
                                            <!-- Editar -->
                                            <Link :href="route('producto.edit', producto.codProducto)" class="btn btn-warning btn-sm mx-1">
                                                <i class="fas fa-edit"></i> Editar
                                            </Link>

                                            <!-- Eliminar -->
                                            <button @click="confirmDeleteProducto(producto)" class="btn btn-danger btn-sm mx-1">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex justify-between mt-4">
                            <div v-if="productos?.prev_page_url">
                                <Link :href="productos?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="productos?.next_page_url">
                                <Link :href="productos?.next_page_url" class="btn btn-primary">
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
                <p>¿Estás seguro de que deseas eliminar el producto <strong>{{ selectedProducto?.nombre }}</strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteProducto" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
                <button @click="showModal = false" class="ml-4 btn btn-secondary">Cancelar</button>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<style scoped>
/* Estilo para mejorar la apariencia de los botones y tablas */
.table-auto th, .table-auto td {
    text-align: left;
    vertical-align: middle;
}

.table-auto th {
    background-color: #4B5563; /* Gray background */
    color: #fff;
}

.table-auto tr:nth-child(even) {
    background-color: #F3F4F6; /* Light gray rows */
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
