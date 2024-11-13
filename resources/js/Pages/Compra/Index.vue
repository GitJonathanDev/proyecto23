<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Propiedades recibidas desde Inertia
const props = defineProps({
    compras: Object
});

// Estado para manejar la visibilidad del modal y la compra seleccionada
const showModal = ref(false);
const selectedCompra = ref(null);

// Función para abrir el modal de confirmación de eliminación
const confirmDeleteCompra = (item) => {
    selectedCompra.value = item;
    showModal.value = true;
};

// Función para manejar la eliminación
const deleteCompra = () => {
    if (selectedCompra.value) {
        router.delete(route('compra.destroy', selectedCompra.value.codCompra));
        showModal.value = false;
    }
};
</script>

<template>
    <plantillanav/>
    <AppLayout title="Gestionar Compras">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Compras
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-center mb-6">Lista de Compras</h1>

                        <!-- Contenedor de los botones (Nuevo tipo de usuario y búsqueda) -->
                        <div class="flex justify-between items-center mb-6">
                            <!-- Registrar compra -->
                            <Link :href="route('compra.create')" class="btn btn-primary inline-flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Registrar</span>
                            </Link>

                            <!-- Formulario de búsqueda -->
                            <form :action="route('compra.index')" method="get" class="flex space-x-2">
                                <select name="criterio" class="form-select">
                                    <option value="fechaCompra">Fecha</option>
                                    <option value="codProveedorF">ID Proveedor</option>
                                </select>
                                <TextInput class="w-full" name="buscar" placeholder="Buscar Compra" />
                                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                                    <i class="fas fa-search"></i>
                                    <span>Buscar</span>
                                </button>
                            </form>
                        </div>

                        <!-- Tabla de compras -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-3 text-left">Código de Compra</th>
                                        <th class="p-3 text-left">Fecha de Compra</th>
                                        <th class="p-3 text-left">Monto Total</th>
                                        <th class="p-3 text-left">Proveedor</th>
                                        <th class="p-3 text-left">Encargado</th>
                                        <th class="p-3 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="compra in compras.data" :key="compra.codCompra" class="border-b">
                                        <td class="p-3">{{ compra.codCompra }}</td>
                                        <td class="p-3">{{ compra.fechaCompra}}</td>
                                        <td class="p-3">{{ compra.montoTotal }}Bs.</td>
                                        <td class="p-3">{{ compra.proveedor.nombre }}</td>
                                        <td class="p-3">{{ compra.encargado.nombre }}</td>
                                        <td class="p-3 text-center">
                                            <!-- Ver detalles -->
                                            <Link :href="route('compra.show', compra.codCompra)" class="btn btn-info btn-sm mx-1">
                                                <i class="fas fa-eye"></i> Ver Detalle
                                            </Link>

                                            <!-- Eliminar -->
                                            <button @click="confirmDeleteCompra(compra)" class="btn btn-danger btn-sm mx-1">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex justify-between mt-4">
                            <div v-if="compras?.prev_page_url">
                                <Link :href="compras?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="compras?.next_page_url">
                                <Link :href="compras?.next_page_url" class="btn btn-primary">
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
                <p>¿Estás seguro de que deseas eliminar la compra <strong>{{ selectedCompra?.codCompra }}</strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteCompra" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
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

<script>
// Filtros para formato de fecha y moneda
import { defineComponent } from 'vue';

export default defineComponent({
    filters: {
        formatDate(value) {
            if (!value) return '';
            return new Date(value).toLocaleDateString();
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(value);
        }
    }
});
</script>
