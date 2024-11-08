<script setup>
import { ref, watch, onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { defineProps } from 'vue';

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
const tipoRow = ref(null);
const mensajeTipo = ref(null);

// Función para actualizar los tipos según el servicio seleccionado
const actualizarTipos = () => {
    const servicioId = form.codServicioF;
    if (servicioId) {
        tipoRow.value.style.display = 'block';

        // Obtener los tipos registrados para el servicio seleccionado
        const tiposRegistradosServicio = props.tiposRegistrados[servicioId] || [];

        // Filtrar los tipos disponibles para excluir los tipos registrados
        const tiposMostrar = props.tiposDisponibles.filter(tipo => !tiposRegistradosServicio.includes(tipo));

        // Actualizar las opciones de tipo
        form.tipo = ''; // Resetear el tipo seleccionado
        if (tiposMostrar.length === 0) {
            mensajeTipo.value.classList.remove('d-none');
        } else {
            mensajeTipo.value.classList.add('d-none');
        }

        return tiposMostrar;
    } else {
        tipoRow.value.style.display = 'none';
        mensajeTipo.value.classList.add('d-none');
    }
    return [];
};

// Lógica de validación
const validateCodServicioF = () => {
    return form.codServicioF !== '';
};

const validateTipo = () => {
    return form.tipo !== '';
};

const validatePrecio = () => {
    const precio = parseFloat(form.precio);
    return !isNaN(precio) && precio > 0;
};

const validateForm = () => {
    const isCodServicioFValid = validateCodServicioF();
    const isTipoValid = validateTipo();
    const isPrecioValid = validatePrecio();

    submitButton.value.disabled = !(isCodServicioFValid && isTipoValid && isPrecioValid);
};

// Función para enviar el formulario
const submit = () => {
    form.post(route('precioServicio.store'), {
        onSuccess: () => {
            router.get(route('precioServicio.index'));
        },
    });
};

// Al montar el componente, inicializamos las opciones de tipo
onMounted(() => {
    actualizarTipos();
});

// Reaccionamos a los cambios en los campos
watch(() => form.codServicioF, actualizarTipos);
watch([() => form.codServicioF, () => form.tipo, () => form.precio], validateForm);
</script>

<template>
    <AppLayout title="Registrar Precio de Servicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Precio de Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" novalidate>
                            <!-- Selección de Servicio -->
                            <div class="mb-4">
                                <InputLabel for="codServicioF" value="Servicio" />
                                <InputError :message="errors.codServicioF" />
                                <select
                                    v-model="form.codServicioF"
                                    id="codServicioF"
                                    class="mt-1 block w-full"
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

                            <!-- Selección de Tipo (desplegado dinámicamente) -->
                            <div class="mb-4" ref="tipoRow" style="display: none;">
                                <InputLabel for="tipo" value="Tipo" />
                                <InputError :message="errors.tipo" />
                                <select
                                    v-model="form.tipo"
                                    id="tipo"
                                    class="mt-1 block w-full"
                                    required
                                >
                                    <option value="">Seleccione un tipo</option>
                                    <option
                                        v-for="tipo in actualizarTipos()"
                                        :key="tipo"
                                        :value="tipo"
                                    >
                                        {{ tipo }}
                                    </option>
                                </select>
                                <div ref="mensajeTipo" class="invalid-feedback d-none">
                                    No hay tipos disponibles para seleccionar.
                                </div>
                            </div>

                            <!-- Campo Precio -->
                            <div class="mb-4">
                                <InputLabel for="precio" value="Precio" />
                                <InputError :message="errors.precio" />
                                <TextInput
                                    v-model="form.precio"
                                    id="precio"
                                    class="mt-1 block w-full"
                                    type="number"
                                    step="0.01"
                                    placeholder="Ingrese el precio"
                                    required
                                />
                            </div>

                            <!-- Botones -->
                            <div class="text-center">
                                <Link href="{{ route('precioServicio.index') }}" class="btn btn-secondary me-3">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>
                                <PrimaryButton
                                    ref="submitButton"
                                    class="mt-4"
                                    :disabled="!validateCodServicioF() || !validateTipo() || !validatePrecio() || form.processing"
                                >
                                    <i class="fas fa-save"></i> Guardar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.invalid-feedback {
    color: red;
}
</style>
