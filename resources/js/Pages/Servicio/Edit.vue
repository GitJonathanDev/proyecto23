<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Recibimos los datos del servicio, horarios y errores del padre
const props = defineProps(['servicio', 'horarios', 'errors']);

// Inicializamos el formulario con los datos del servicio
const form = useForm({
    nombre: props.servicio?.nombre || '',
    descripcion: props.servicio?.descripcion || '',
    codHorarioF: props.servicio?.codHorarioF || '',
});

// Función para manejar el envío del formulario
const submit = () => {
    form.put(route('servicio.update', props.servicio.codServicio));
};

// Validaciones del formulario
const validateNombre = () => {
    return form.nombre.length > 2 && form.nombre.length < 151;
};

const validateDescripcion = () => {
    return form.descripcion.trim() !== '';
};

const validateCodHorarioF = () => {
    return form.codHorarioF !== '';
};
</script>

<template>
    <AppLayout title="Modificar Servicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <!-- Errores de validación -->
                        <div v-if="form.errors" class="alert alert-danger">
                            <ul>
                                <li v-for="(error, index) in form.errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>

                        <!-- Formulario -->
                        <form @submit.prevent="submit">
                            <div class="mb-3 row">
                                <InputLabel for="nombre" value="Nombre" />
                                <InputError :message="form.errors.nombre" />
                                <input 
                                    v-model="form.nombre"
                                    type="text" 
                                    id="nombre" 
                                    class="form-control"
                                    placeholder="Ingrese el nombre del servicio"
                                    required 
                                />
                            </div>

                            <div class="mb-3 row">
                                <InputLabel for="descripcion" value="Descripción" />
                                <InputError :message="form.errors.descripcion" />
                                <textarea 
                                    v-model="form.descripcion"
                                    id="descripcion"
                                    class="form-control"
                                    placeholder="Ingrese la descripción del servicio"
                                    required
                                ></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="codHorarioF" class="form-label">Horario:</label>
                                <select 
                                    v-model="form.codHorarioF"
                                    id="codHorarioF"
                                    class="form-select"
                                    required 
                                >
                                    <option v-for="horario in props.horarios" :key="horario.codHorario" :value="horario.codHorario">
                                        Hora inicio: {{ horario.horaInicio }} - Hora fin: {{ horario.horaFin }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.codHorarioF" />
                            </div>

                            <div class="text-center mt-4">
                                <Link 
                                    href="{{ route('servicio.index') }}" 
                                    class="btn btn-secondary me-2"
                                >
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>
                                <PrimaryButton
                                    type="submit"
                                    :disabled="!validateNombre() || !validateDescripcion() || !validateCodHorarioF() || form.processing"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-pencil-alt"></i> Modificar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
