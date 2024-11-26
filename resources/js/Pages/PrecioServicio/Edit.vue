<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Recibimos los datos del formulario y errores
const props = defineProps({
  precioServicio: Object,
  servicios: Array,
  tiposDisponibles: Array,
  errors: Object,
});

const form = useForm({
  codServicio: props.precioServicio?.codServicioF || '',
  tipo: props.precioServicio?.tipo || '',
  precio: props.precioServicio?.precio || '',
});

onMounted(() => {

});
const validateCodServicio = computed(() => form.codServicio !== '');
const validateTipo = computed(() => form.tipo !== '');
const validatePrecio = computed(() => {
  const precio = parseFloat(form.precio);
  return !isNaN(precio) && precio > 0;
});

// Función para enviar el formulario
const submit = () => {
  form.put(route('precioServicio.update', props.precioServicio.codPrecioServicio), {
    onSuccess: () => {
      // Redirige al listado después de la actualización
      Inertia.visit(route('precioServicio.index'));
    },
  });
};

// Revalidación del formulario al cambiar algún campo
watch([() => form.codServicio, () => form.tipo, () => form.precio], () => {
  validateForm();
});

const validateForm = () => {
  const isCodServicioValid = validateCodServicio.value;
  const isTipoValid = validateTipo.value;
  const isPrecioValid = validatePrecio.value;

  // Habilitar/deshabilitar el botón de enviar basado en la validación
  return isCodServicioValid && isTipoValid && isPrecioValid;
};
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name"/>
  <AppLayout title="Modificar Precio de Servicio">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight ee">Modificar Precio de Servicio</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6 ee">Editar Precio de Servicio</h1>
            <form @submit.prevent="submit" novalidate>
              <!-- Servicio -->
              <div class="mb-4">
                <InputLabel for="codServicio" value="Servicio" class="bb" />
                <InputError :message="errors.codServicio" />
                <select
                  v-model="form.codServicio"
                  id="codServicio"
                  class="mt-1 block w-full cc"
                  name="codServicio"
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

              <!-- Tipo -->
              <div class="mb-4">
                <InputLabel for="tipo" value="Tipo" class="bb" />
                <InputError :message="errors.tipo" />
                <select
                  v-model="form.tipo"
                  id="tipo"
                  class="mt-1 block w-full cc"
                  name="tipo"
                  required
                >
                  <option value="">Seleccione un tipo</option>
                  <option
                    v-for="tipo in props.tiposDisponibles"
                    :key="tipo"
                    :value="tipo"
                  >
                    {{ tipo }}
                  </option>
                </select>
              </div>

              <!-- Precio -->
              <div class="mb-4">
                <InputLabel for="precio" value="Precio" class="bb" />
                <InputError :message="errors.precio" />
                <TextInput
                  v-model="form.precio"
                  type="text"
                  id="precio"
                  class="mt-1 block w-full cc"
                  name="precio"
                  required
                />
                <div v-if="errors.precio" class="dd">
                  El precio debe ser un número mayor a 0, incluyendo decimales.
                </div>
              </div>

              <!-- Botones -->
              <div class="text-center mt-4 ff">
                <Link :href="route('precioServicio.index')" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  :disabled="!validateForm() || form.processing"
                  type="submit"
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
  margin-top: calc(60px + 1rem);
}
</style>
