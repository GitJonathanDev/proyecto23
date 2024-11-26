<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Propiedades desde Inertia
const props = defineProps({
  horario: Object,
  errors: Object,
});

// Crear formulario para gestionar los horarios
const form = useForm({
  horaInicio: '',
  horaFin: '',
});

// Crear una referencia para el botón de envío
const submitButton = ref(null);

// Función para convertir la hora en formato "HH:mm"
const formatTime = (time) => {
  const [hours, minutes] = time.split(':');
  return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
};

// Función para convertir la hora en formato Date
const timeToDate = (time) => {
  const [hours, minutes] = time.split(':').map(Number);
  const date = new Date();
  date.setHours(hours, minutes, 0, 0); // Establece la hora y minutos en un objeto Date
  return date;
};

// Función para formatear un objeto Date a "HH:mm"
const dateToTimeString = (date) => {
  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');
  return `${hours}:${minutes}`;
};

// Inicializar los valores del formulario si existen
form.horaInicio = formatTime(props.horario?.horaInicio || '');
form.horaFin = formatTime(props.horario?.horaFin || '');

// Validación de hora de inicio
const validateHoraInicio = () => {
  return form.horaInicio !== '';
};

// Validación de hora de fin
const validateHoraFin = () => {
  return form.horaFin !== '';
};

// Validación de que la hora de fin sea mayor que la hora de inicio
const validateHoraRange = () => {
  const horaInicioDate = timeToDate(form.horaInicio); // Convertir hora de inicio a Date
  const horaFinDate = timeToDate(form.horaFin); // Convertir hora de fin a Date

  // Comparar usando getTime() para evitar problemas con las fechas
  return horaInicioDate.getTime() < horaFinDate.getTime(); // Comparamos los valores de tiempo en milisegundos
};

// Función para habilitar/deshabilitar el botón de envío
const validateForm = () => {
  const isValid = validateHoraInicio() && validateHoraFin() && validateHoraRange();
  return isValid; // Devuelve si el formulario es válido
};

// Función para manejar el envío del formulario
const submit = () => {
  // Asegúrate de enviar las horas en el formato adecuado
  form.horaInicio = formatTime(form.horaInicio);
  form.horaFin = formatTime(form.horaFin);

  form.put(route('horario.update', props.horario.codHorario), {
    onSuccess: () => {
      // Redirigir al listado de horarios en caso de éxito
      router.get(route('horario.index'));
    },
  });
};

// Recalcular la validación del formulario cada vez que los valores cambien
watch([() => form.horaInicio, () => form.horaFin], () => {
  // Aseguramos que el botón se habilite o deshabilite en cada cambio
  if (submitButton.value) {
    submitButton.value.disabled = !validateForm();
  }
});
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <AppLayout title="Editar Horario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Horario</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <!-- Título principal -->
            <h1 class="text-2xl font-bold text-center mb-6">Editar Horario</h1>

            <!-- Formulario -->
            <form @submit.prevent="submit" novalidate>
              <!-- Hora de inicio -->
              <div class="mb-4">
                <InputLabel for="horaInicio" value="Hora de inicio" class="bb" />
                <InputError :message="props.errors.horaInicio" />
                <TextInput
                  v-model="form.horaInicio"
                  id="horaInicio"
                  type="time"
                  class="mt-1 block w-full cc"
                  required
                />
                <div v-if="!validateHoraInicio() && form.horaInicio" class="text-red-500 text-sm dd">
                  * La hora de inicio es obligatoria.
                </div>
              </div>

              <!-- Hora de fin -->
              <div class="mb-4">
                <InputLabel for="horaFin" value="Hora de fin" class="bb" />
                <InputError :message="props.errors.horaFin" />
                <TextInput
                  v-model="form.horaFin"
                  id="horaFin"
                  type="time"
                  class="mt-1 block w-full cc"
                  required
                />
                <div v-if="!validateHoraRange() && form.horaFin" class="text-red-500 text-sm dd">
                  * La hora de fin debe ser mayor que la hora de inicio.
                </div>
              </div>

              <div class="text-center mt-4">
                <!-- Botón de Atrás -->
                <Link :href="route('horario.index')" class="btn btn-secondary me-3">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>

                <!-- Botón de Enviar -->
                <PrimaryButton
                  ref="submitButton"
                  class="btn btn-primary"
                  :disabled="!validateForm() || form.processing"
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
.py-12 {
  margin-top: calc(10px + 1rem);
}
</style>
