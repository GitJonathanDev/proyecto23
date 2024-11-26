<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

const props = defineProps({
    compras: Object
});

// Variables para manejar el rango de fechas
const fechaInicio = ref('');
const fechaFin = ref('');

// Función para formatear la fecha
const formatoFecha = (fecha) => {
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES'); // Puedes cambiar el formato a tu gusto
};

// Función para actualizar los parámetros del rango de fechas y realizar la búsqueda
const filtrarCompras = () => {
    if (fechaInicio.value && fechaFin.value) {
        // Filtra las compras por las fechas seleccionadas
        router.get(route('reportes.compras'), {
            inicio: fechaInicio.value,
            fin: fechaFin.value
        });
    } else {
        alert('Por favor, selecciona ambas fechas.');
    }
};
</script>

<template>
    <plantillanav :userName="$page.props.auth.user.name" />
    <AppLayout title="Reporte de Compras">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reporte de Compras
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6">Reporte de Compras</h1>

                        <!-- Filtro de fechas -->
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex space-x-2">
                                <TextInput v-model="fechaInicio" type="date" class="w-full" placeholder="Fecha Inicio" />
                                <TextInput v-model="fechaFin" type="date" class="w-full" placeholder="Fecha Fin" />
                            </div>
                            <PrimaryButton @click="filtrarCompras" class="btn btn-primary">
                                Filtrar
                            </PrimaryButton>
                        </div>

                        <!-- Verificar si no hay compras -->
                        <div v-if="props.compras.data.length === 0" class="text-center text-red-600">
                            <p>No se realizaron compras en el rango de fechas seleccionado.</p>
                        </div>

                        <!-- Tabla de compras -->
                        <div class="overflow-x-auto" v-else>
                            <table class="table-auto w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="p-3 text-left">Código Compra</th>
                                        <th class="p-3 text-left">Fecha</th>
                                        <th class="p-3 text-left">Monto Total</th>
                                        <th class="p-3 text-left">Proveedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="compra in props.compras.data" :key="compra.codCompra" class="border-b">
                                        <td class="p-3">{{ compra.codCompra }}</td>
                                        <td class="p-3">{{ formatoFecha(compra.fechaCompra) }}</td>
                                        <td class="p-3">{{ compra.montoTotal }} Bs.</td>
                                        <td class="p-3">{{ compra.proveedor.nombre }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex justify-between mt-4">
                            <div v-if="props.compras?.prev_page_url">
                                <Link :href="props.compras?.prev_page_url" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </Link>
                            </div>
                            <div v-if="props.compras?.next_page_url">
                                <Link :href="props.compras?.next_page_url" class="btn btn-primary">
                                    Siguiente <i class="fas fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.table-auto th, .table-auto td {
    text-align: left;
    vertical-align: middle;
}
</style>
