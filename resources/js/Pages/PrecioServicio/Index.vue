<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import { router } from '@inertiajs/vue3';
import plantillanav from '@/Layouts/plantillanav.vue';

const props = defineProps({
    preciosServicio: Object, 
    criterio: String, 
        buscar: String 
});
const showModal = ref(false);
const selectedPrecioServicio = ref(null);
const form = useForm({
    criterio: props.criterio || 'tipo',
    buscar: props.buscar || '',
});
const confirmDeletePrecioServicio = (item) => {
    selectedPrecioServicio.value = item;
    showModal.value = true;
};
const deletePrecioServicio = () => {
    if (selectedPrecioServicio.value) {
        router.delete(route('precioServicio.destroy', selectedPrecioServicio.value.codPrecioServicio));
        showModal.value = false;
    }
};
const submitSearch = () => {
    form.get(route('precioServicio.index'));
};
</script>
<template>
    <plantillanav/>
    <AppLayout title="Gestionar Precios de Servicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Precios de Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-center mb-6">Lista de Precios de Servicio</h1>

                        <div class="flex justify-between items-center mb-6">
                            <Link :href="route('precioServicio.create')" class="btn btn-primary inline-flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Registrar</span>
                            </Link>
                            <form @submit.prevent="submitSearch" class="flex space-x-2">
                                <select v-model="form.criterio" class="form-select">
                                    <option value="tipo" :selected="form.criterio === 'tipo'">Tipo</option>
                                    <option value="precio" :selected="form.criterio === 'precio'">Precio</option>
                                </select>
                                <TextInput v-model="form.buscar" class="w-full" placeholder="Buscar precio de servicio" />
                                <button type="submit" class="btn btn-outline-secondary flex items-center space-x-2">
                                    <i class="fas fa-search"></i>
                                    <span>Buscar</span>
                                </button>
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-3 text-left">Código</th>
                                        <th class="p-3 text-left">Tipo</th>
                                        <th class="p-3 text-left">Precio</th>
                                        <th class="p-3 text-left">Servicio</th>
                                        <th class="p-3 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in props.preciosServicio.data" :key="item.codPrecioServicio" class="border-b">
                                        <td class="p-3">{{ item.codPrecioServicio }}</td>
                                        <td class="p-3">{{ item.tipo }}</td>
                                        <td class="p-3">{{ item.precio }} Bs.</td>
                                        <td class="p-3">{{ item.servicio.nombre }}</td>
                                        <td class="p-3 text-center">
                                            <Link :href="route('precioServicio.edit', item.codPrecioServicio)" class="btn btn-warning btn-sm mx-1">
                                                <i class="fas fa-edit"></i> Editar
                                            </Link>
                                            <button @click="confirmDeletePrecioServicio(item)" class="btn btn-danger btn-sm mx-1">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-between mt-4">
                            <div v-if="props.preciosServicio?.prev_page_url">
                                <Link :href="props.preciosServicio?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="props.preciosServicio?.next_page_url">
                                <Link :href="props.preciosServicio?.next_page_url" class="btn btn-primary">
                                    Siguiente <i class="fas fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DialogModal :show="showModal" @close="showModal = false">
            <template v-slot:title>
                <h1 class="text-lg font-semibold">Confirmar Eliminación</h1>
            </template>
            <template v-slot:content>
                <p>¿Estás seguro de que deseas eliminar el precio de servicio de tipo <strong>{{ selectedPrecioServicio?.tipo }}</strong>?</p>
            </template>
            <template v-slot:footer>
                <PrimaryButton @click="deletePrecioServicio" class="bg-red-600 hover:bg-red-800">Eliminar</PrimaryButton>
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
    background-color: #4B5563;
    color: white;
}

.table-auto tr:nth-child(even) {
    background-color: #F3F4F6;
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
