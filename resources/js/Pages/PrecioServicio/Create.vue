<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { defineProps } from 'vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Recibiendo propiedades desde Inertia
const props = defineProps({
    servicios: Array,
    tiposRegistrados: Object,
    tiposDisponibles: Array,
    errors: Object,
});

// Formularios y campos
const form = useForm({
    codServicioF: '', // Código de servicio seleccionado
    tipo: '',          // Tipo de servicio seleccionado
    precio: '',        // Precio del servicio
});

// Referencias para habilitar y deshabilitar el botón
const submitButton = ref(null);

// Computados
const tiposDisponiblesFiltrados = computed(() => {
    const servicioId = form.codServicioF;
    if (!servicioId) return props.tiposDisponibles; // Si no hay servicio seleccionado, mostrar todos los tipos
    const tiposRegistradosServicio = props.tiposRegistrados[servicioId] || [];
    return props.tiposDisponibles.filter(tipo => !tiposRegistradosServicio.includes(tipo)); // Filtra los tipos disponibles
});

const mostrarMensajeTipo = computed(() => {
    if (!form.codServicioF || tiposDisponiblesFiltrados.value.length > 0) {
        return false;
    }
    return props.tiposRegistrados[form.codServicioF]?.length > 0;
});

// Validación
const validateForm = computed(() => {
    return form.codServicioF && form.tipo && parseFloat(form.precio) > 0;
});

// Función para enviar el formulario
const submit = () => {
    form.post(route('precioServicio.store'), {
        onSuccess: () => {
            router.get(route('precioServicio.index'));
        },
    });
};

onMounted(() => {
    validateForm.value; // Para asegurarnos de que la validación se hace al montar
});

// Reaccionamos a los cambios en el formulario
watch([() => form.codServicioF, () => form.tipo, () => form.precio], () => {
    // Validar cada vez que uno de los campos cambie
    validateForm.value; // Actualizar estado de validación
});
</script>

<template>
    <plantillanav :userName="$page.props.auth.user.name"/>
    <AppLayout title="Registrar Precio de Servicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Precio de Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6 ee">Registrar Precio de Servicio</h1>
                        <form @submit.prevent="submit" novalidate>
                            <!-- Selección de Servicio -->
                            <div class="mb-4">
                                <InputLabel for="codServicioF" value="Servicio" class="bb" />
                                <InputError :message="errors.codServicioF" />
                                <select
                                    v-model="form.codServicioF"
                                    id="codServicioF"
                                    class="mt-1 block w-full cc"
                                    required
                                >
                                    <option value="">Seleccione un servicio</option>
                                    <option
                                        v-for="servicio in props.servicios"
                                        :key="servicio.codServicio"
                                        :value="servicio.codServicio"
                                    >
                                        {{ servicio.nombre }}
                                    </option>
                                </select>
                            </div>

                            <!-- Selección de Tipo -->
                            <div class="mb-4" v-show="form.codServicioF">
                                <InputLabel for="tipo" value="Tipo" class="bb" />
                                <InputError :message="errors.tipo" />
                                <select
                                    v-model="form.tipo"
                                    id="tipo"
                                    class="mt-1 block w-full cc"
                                    required
                                >
                                    <option value="">Seleccione un tipo</option>
                                    <option
                                        v-for="tipo in tiposDisponiblesFiltrados"
                                        :key="tipo"
                                        :value="tipo"
                                    >
                                        {{ tipo }}
                                    </option>
                                </select>
                                <div v-show="mostrarMensajeTipo" class="text-red-500 text-sm dd">
                                    * No hay tipos disponibles para seleccionar.
                                </div>
                            </div>

                            <!-- Campo Precio -->
                            <div class="mb-4">
                                <InputLabel for="precio" value="Precio" class="bb" />
                                <InputError :message="errors.precio" />
                                <TextInput
                                    v-model="form.precio"
                                    id="precio"
                                    class="mt-1 block w-full cc"
                                    type="number"
                                    step="0.01"
                                    placeholder="Ingrese el precio"
                                    required
                                />
                                <div v-if="!validateForm && form.precio.length > 0" class="text-red-500 text-sm dd">
                                    * El precio debe ser mayor a 0.
                                </div>
                            </div>

                            <!-- Botón Guardar -->
                            <div class="text-center ff">
                                <Link href="{{ route('precioServicio.index') }}" class="btn btn-secondary me-3">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>
                                <PrimaryButton
                                    ref="submitButton"
                                    class="mt-4 btn-primary"
                                    :disabled="!validateForm || form.processing"
                                >
                                    <i class="fas fa-save"></i> Guardar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <VisitaFooter />
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
