<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

const props = defineProps({
    membresias: Object,
});
const showModal = ref(false);
const selectedMembresia = ref(null);
const searchQuery = ref('');
const searchCriterio = ref('descripcion');

const confirmDeleteMembresia = (item) => {
    selectedMembresia.value = item;
    showModal.value = true;
};

const deleteMembresia = () => {
    if (selectedMembresia.value) {
        router.delete(route('membresia.destroy', selectedMembresia.value.codMembresia));
        showModal.value = false;
    }
};

const searchMembresia = () => {
    router.get(route('membresia.index'), {
        criterio: searchCriterio.value,
        buscar: searchQuery.value,
    });
};
</script>

<template>
    <plantillanav/>
    <AppLayout title="Gestionar Membresías">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Membresías
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-center mb-6">Lista de Membresías</h1>
                        <div class="flex justify-between items-center mb-6">
                            <Link :href="route('membresia.create')" class="btn btn-primary inline-flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Registrar</span>
                            </Link>

                            <!-- Formulario de búsqueda -->
                            <form @submit.prevent="searchMembresia" class="flex space-x-2">
                                <select v-model="searchCriterio" class="form-select w-32">
                                    <option value="descripcion">Descripción</option>
                                </select>
                                <TextInput v-model="searchQuery" class="w-full" placeholder="Buscar Membresía" />
                                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                                    <i class="fas fa-search"></i>
                                    <span>Buscar</span>
                                </button>
                            </form>
                        </div>

                        <!-- Tabla de membresías -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-3 text-left">Código Membresía</th>
                                        <th class="p-3 text-left">Descripción</th>
                                        <th class="p-3 text-left">Precio Total</th>
                                        <th class="p-3 text-left">Cliente</th>
                                        <th class="p-3 text-left">Encargado</th>
                                        <th class="p-3 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in membresias.data" :key="item.codMembresia" class="border-b">
                                        <td class="p-3">{{ item.codMembresia }}</td>
                                        <td class="p-3">{{ item.descripcion }}</td>
                                        <td class="p-3">Bs. {{ item.precioTotal.toFixed(2) }}</td>
                                        <td class="p-3">{{ item.cliente?.nombre || 'No disponible' }}</td>
                                        <td class="p-3">{{ item.encargado?.nombre || 'No disponible' }}</td>
                                        <td class="p-3 text-center">
                                            <Link :href="route('membresia.show', item.codMembresia)" class="btn btn-info btn-sm mx-1">
                                                <i class="fas fa-eye"></i> Ver Detalle
                                            </Link>
                                            <!-- Eliminar -->
                                            <button @click="confirmDeleteMembresia(item)" class="btn btn-danger btn-sm mx-1">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex justify-between mt-4">
                            <div v-if="membresias?.prev_page_url">
                                <Link :href="membresias?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="membresias?.next_page_url">
                                <Link :href="membresias?.next_page_url" class="btn btn-primary">
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
                <p>¿Estás seguro de que deseas eliminar la membresía <strong>{{ selectedMembresia?.descripcion }}</strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deleteMembresia" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
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

.btn-info {
    background-color: #0D6EFD;
    color: white;
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
