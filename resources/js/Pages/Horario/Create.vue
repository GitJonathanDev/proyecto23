<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <AppLayout title="Registrar Horario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registrar Horario
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Registrar Horario</h1>
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

              <!-- Botones -->
              <div class="text-center">
                <Link href="{{ route('horario.index') }}" class="btn btn-secondary me-3">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  ref="submitButton"
                  class="mt-4 btn-primary"
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


const props = defineProps({
  errors: Object,
});

const form = useForm({
  horaInicio: '',
  horaFin: '',
});

const submitButton = ref(null);

const timeToDate = (time) => {
  const [hours, minutes] = time.split(':').map(Number);
  const date = new Date();
  date.setHours(hours, minutes, 0, 0);
  return date;
};

const validateHoraInicio = () => form.horaInicio !== '';
const validateHoraFin = () => form.horaFin !== '';
const validateHoraRange = () => {
  const horaInicioDate = timeToDate(form.horaInicio);
  const horaFinDate = timeToDate(form.horaFin);
  return horaInicioDate.getTime() < horaFinDate.getTime();
};

const validateForm = () => {
  return validateHoraInicio() && validateHoraFin() && validateHoraRange();
};

const submit = () => {
  form.post(route('horario.store'), {
    onSuccess: () => {
      router.get(route('horario.index'));
    },
  });
};

watch([() => form.horaInicio, () => form.horaFin], () => {
  if (submitButton.value) {
    submitButton.value.disabled = !validateForm();
  }
});
</script>

<style scoped>
.py-12 {
  margin-top: calc(10px + 1rem);
}
</style>
