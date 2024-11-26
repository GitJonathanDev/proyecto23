<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

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
    <plantillanav :userName="$page.props.auth.user.name" />
    <AppLayout title="Modificar Servicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6">Editar Servicio</h1>

                        <!-- Errores de validación -->
                        <div v-if="form.errors" class="alert alert-danger">
                            <ul>
                                <li v-for="(error, index) in form.errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>

                        <!-- Formulario -->
                        <form @submit.prevent="submit" novalidate>
                            <!-- Nombre -->
                            <div class="mb-4">
                                <InputLabel for="nombre" value="Nombre" class="bb" />
                                <InputError :message="form.errors.nombre" />
                                <input 
                                    v-model="form.nombre"
                                    type="text" 
                                    id="nombre" 
                                    class="mt-1 block w-full cc"
                                    placeholder="Ingrese el nombre del servicio"
                                    required 
                                    @input="validateForm"
                                />
                                <div v-if="!validateNombre() && form.nombre.length > 0" class="text-red-500 text-sm dd">
                                    * El nombre debe tener entre 3 y 150 caracteres.
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-4">
                                <InputLabel for="descripcion" value="Descripción" class="bb" />
                                <InputError :message="form.errors.descripcion" />
                                <textarea 
                                    v-model="form.descripcion"
                                    id="descripcion"
                                    class="mt-1 block w-full cc"
                                    placeholder="Ingrese la descripción del servicio"
                                    required
                                ></textarea>
                                <div v-if="!validateDescripcion() && form.descripcion.length > 0" class="text-red-500 text-sm dd">
                                    * La descripción no puede estar vacía.
                                </div>
                            </div>

                            <!-- Horario -->
                            <div class="mb-4">
                                <label for="codHorarioF" class="form-label bb">Horario:</label>
                                <select 
                                    v-model="form.codHorarioF"
                                    id="codHorarioF"
                                    class="mt-1 block w-full cc"
                                    required 
                                >
                                    <option v-for="horario in props.horarios" :key="horario.codHorario" :value="horario.codHorario">
                                        Hora inicio: {{ horario.horaInicio }} - Hora fin: {{ horario.horaFin }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.codHorarioF" />
                                <div v-if="!validateCodHorarioF()" class="text-red-500 text-sm dd">
                                    * Debe seleccionar un horario.
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="text-center mt-4">
                                <Link 
                                    :href=" route('servicio.index')" 
                                    class="btn btn-secondary me-3"
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
            <VisitaFooter />
        </div>
    </AppLayout>
</template>

<style scoped>
.py-12 {
  margin-top: calc(10px + 1rem);
}
</style>
