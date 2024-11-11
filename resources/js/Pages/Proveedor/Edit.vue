<script setup>
import { ref, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Propiedades recibidas del controlador
const props = defineProps({
  proveedor: Object,
  errors: Object
});

// Inicializamos el formulario con los datos del proveedor
const form = useForm({
  nombre: props.proveedor?.nombre || '',
  direccion: props.proveedor?.direccion || '',
  telefono: props.proveedor?.telefono || ''
});

// Referencias a los inputs para realizar validaciones
const submitButton = ref(null);

// Función para enviar el formulario
const submit = () => {
  form.put(route('proveedor.update', props.proveedor.codProveedor), {
    onSuccess: () => {
      // Redirige al listado de proveedores después de una actualización exitosa
      router.get(route('proveedor.index'));
    }
  });
};

// Funciones de validación para cada campo
const validateNombre = () => {
  return form.nombre.length > 2 && form.nombre.length < 31;
};

const validateDireccion = () => {
  return form.direccion.length > 5 && form.direccion.length < 201;
};

const validateTelefono = () => {
  return /^\d{8,10}$/.test(form.telefono);
};

// Función para habilitar/deshabilitar el botón de enviar
const validateForm = () => {
  submitButton.value.disabled = !(validateNombre() && validateDireccion() && validateTelefono());
};

// Verificación de validaciones al escribir
watch([() => form.nombre, () => form.direccion, () => form.telefono], () => {
  validateForm();
});
</script>

<template>
  <AppLayout title="Editar Proveedor">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Proveedor
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <!-- Errores de validación -->
            <div v-if="form.errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in form.errors" :key="index">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit">
              <!-- Nombre -->
              <div class="mb-3 row">
                <InputLabel for="nombre" value="Nombre" />
                <InputError :message="form.errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  type="text"
                  id="nombre"
                  class="form-control"
                  placeholder="Ingrese el nombre del proveedor"
                  required
                />
              </div>

              <!-- Dirección -->
              <div class="mb-3 row">
                <InputLabel for="direccion" value="Dirección" />
                <InputError :message="form.errors.direccion" />
                <TextInput
                  v-model="form.direccion"
                  type="text"
                  id="direccion"
                  class="form-control"
                  placeholder="Ingrese la dirección del proveedor"
                  required
                />
              </div>

              <!-- Teléfono -->
              <div class="mb-3 row">
                <InputLabel for="telefono" value="Teléfono" />
                <InputError :message="form.errors.telefono" />
                <TextInput
                  v-model="form.telefono"
                  type="tel"
                  id="telefono"
                  class="form-control"
                  placeholder="Ingrese el teléfono del proveedor"
                  required
                />
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link :href=" route('proveedor.index') " class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Atrás
                </Link>

                <PrimaryButton
                  type="submit"
                  ref="submitButton"
                  :disabled="!validateNombre() || !validateDireccion() || !validateTelefono() || form.processing"
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
