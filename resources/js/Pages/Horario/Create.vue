<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import plantillanav from '@/Layouts/plantillanav.vue';

// Propiedades desde Inertia
const props = defineProps({
  errors: Object,
});

// Crear formulario para gestionar los horarios
const form = useForm({
  horaInicio: '',
  horaFin: '',
});

// Referencia al botón de submit para habilitar/deshabilitar
const submitButton = ref(null);

// Función para convertir la hora a un objeto Date
const timeToDate = (time) => {
  const [hours, minutes] = time.split(':').map(Number);
  const date = new Date();
  date.setHours(hours, minutes, 0, 0); // Establece la hora y minutos en un objeto Date
  return date;
};

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

  console.log("Hora Inicio:", horaInicioDate);
  console.log("Hora Fin:", horaFinDate);

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
  form.post(route('horario.store'), {
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
  <plantillanav/>
  <AppLayout title="Registrar Horario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Horario</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <form @submit.prevent="submit" novalidate>
              <!-- Hora de inicio -->
              <div class="mb-4">
                <InputLabel for="horaInicio" value="Hora de inicio" />
                <InputError :message="props.errors.horaInicio" />
                <TextInput
                  v-model="form.horaInicio"
                  id="horaInicio"
                  type="time" 
                  class="mt-1 block w-full"
                  required
                />
                <div v-if="!validateHoraInicio() && form.horaInicio" class="text-red-500 text-sm">
                  * La hora de inicio es obligatoria.
                </div>
              </div>

              <!-- Hora de fin -->
              <div class="mb-4">
                <InputLabel for="horaFin" value="Hora de fin" />
                <InputError :message="props.errors.horaFin" />
                <TextInput
                  v-model="form.horaFin"
                  id="horaFin"
                  type="time"
                  class="mt-1 block w-full"
                  required
                />
                <div v-if="!validateHoraRange() && form.horaFin" class="text-red-500 text-sm">
                  * La hora de fin debe ser mayor que la hora de inicio.
                </div>
              </div>

              <div class="text-center">
                <!-- Botón de Atrás -->
                <Link :href="route('horario.index')" class="btn btn-secondary me-2">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <!-- Botón de Enviar -->
                <PrimaryButton
                  ref="submitButton"
                  class="mt-4"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="!validateForm() || form.processing"
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
.py-12 {
  margin-top: calc(60px + 1rem); 
}
</style>
