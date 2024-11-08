<script setup>
import { ref, watch, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Recibiendo las propiedades desde Inertia
const props = defineProps({
    errors: Object,
    horarios: Array,
});

// Formulario para registrar el servicio
const form = useForm({
    nombre: '',
    descripcion: '',
    codHorarioF: '',
});

// Referencia al botón de submit
const submitButton = ref(null);

// Función para validar el nombre
const validateNombre = () => {
    const nombre = form.nombre.trim();
    return nombre.length > 2 && nombre.length < 151;
};

// Función para validar la descripción
const validateDescripcion = () => {
    return form.descripcion.trim() !== '';
};

// Función para validar el horario
const validateCodHorarioF = () => {
    return form.codHorarioF !== '';
};

// Computada para verificar si el formulario es válido
const isFormValid = computed(() => {
    return validateNombre() && validateDescripcion() && validateCodHorarioF();
});

// Habilitar/deshabilitar el botón de enviar
watch(isFormValid, () => {
    submitButton.value.disabled = !isFormValid.value;
});

// Función para manejar el envío del formulario
const submit = () => {
    form.post(route('servicio.store'), {
        onSuccess: () => {
            router.get(route('servicio.index'));
        },
    });
};
</script>

<template>
    <AppLayout title="Registrar Servicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" novalidate>
                            <!-- Nombre del Servicio -->
                            <div class="mb-4">
                                <InputLabel for="nombre" value="Nombre" />
                                <InputError :message="errors.nombre" />
                                <TextInput 
                                    v-model="form.nombre"
                                    id="nombre"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el nombre del servicio"
                                    required
                                />
                                <div v-if="!validateNombre() && form.nombre.length > 0" class="text-red-500 text-sm">
                                    * El nombre debe tener entre 3 y 150 caracteres.
                                </div>
                            </div>

                            <!-- Descripción del Servicio -->
                            <div class="mb-4">
                                <InputLabel for="descripcion" value="Descripción" />
                                <InputError :message="errors.descripcion" />
                                <textarea
                                    v-model="form.descripcion"
                                    id="descripcion"
                                    class="form-control mt-1 block w-full"
                                    placeholder="Ingrese la descripción del servicio"
                                    rows="3"
                                    required
                                ></textarea>
                                <div v-if="!validateDescripcion() && form.descripcion.length > 0" class="text-red-500 text-sm">
                                    * La descripción es obligatoria.
                                </div>
                            </div>

                            <!-- Selección del Horario -->
                            <div class="mb-4">
                                <InputLabel for="codHorarioF" value="Horario" />
                                <InputError :message="errors.codHorarioF" />
                                <select 
                                    v-model="form.codHorarioF"
                                    id="codHorarioF"
                                    class="form-select mt-1 block w-full"
                                    required
                                >
                                    <option value="">Seleccione un horario</option>
                                    <option 
                                        v-for="horario in props.horarios" 
                                        :key="horario.codHorario" 
                                        :value="horario.codHorario"
                                    >
                                        Hora Inicio: {{ horario.horaInicio }} - Hora Fin: {{ horario.horaFin }}
                                    </option>
                                </select>
                                <div v-if="!validateCodHorarioF() && form.codHorarioF" class="text-red-500 text-sm">
                                    * Debe seleccionar un horario.
                                </div>
                            </div>

                            <div class="text-center">
                                <!-- Botón de Atrás -->
                                <Link href="{{ route('servicio.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>

                                <!-- Botón de Enviar -->
                                <PrimaryButton 
                                    ref="submitButton"
                                    class="mt-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="!isFormValid || form.processing"
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
