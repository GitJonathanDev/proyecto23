<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  errors: Object,
});

const form = useForm({
  codProveedor: '',
  nombre: '',
  direccion: '',
  telefono: '',
});

const submitButton = ref(null);

// Validación de campos
const validateCodProveedor = () => {
  const codProveedor = form.codProveedor.trim();
  const isValid = /^\d{8,12}$/.test(codProveedor);
  return isValid;
};

const validateNombre = () => {
  const nombre = form.nombre.trim();
  const isValid = nombre.length > 2 && nombre.length < 31;
  return isValid;
};

const validateDireccion = () => {
  const direccion = form.direccion.trim();
  const isValid = direccion.length > 5 && direccion.length < 201;
  return isValid;
};

const validateTelefono = () => {
  const telefono = form.telefono.trim();
  const isValid = /^\d{8,10}$/.test(telefono);
  return isValid;
};

// Función para habilitar o deshabilitar el botón de envío
const validateForm = () => {
  submitButton.value.disabled = !(
    validateCodProveedor() &&
    validateNombre() &&
    validateDireccion() &&
    validateTelefono()
  );
};

// Función para manejar el envío del formulario
const submit = () => {
  form.post(route('proveedor.store'), {
    onSuccess: () => {
      router.get(route('proveedor.index'));
    },
  });
};

// Observadores para validar en tiempo real
watch(() => form.codProveedor, validateForm);
watch(() => form.nombre, validateForm);
watch(() => form.direccion, validateForm);
watch(() => form.telefono, validateForm);

</script>

<template>
  <AppLayout title="Registrar Proveedor">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registrar Proveedor
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <form @submit.prevent="submit" novalidate>
              <!-- Código de Proveedor -->
              <div class="mb-4">
                <InputLabel for="codProveedor" value="Código" />
                <InputError :message="errors.codProveedor" />
                <TextInput
                  v-model="form.codProveedor"
                  id="codProveedor"
                  class="mt-1 block w-full"
                  placeholder="Ingrese el código del proveedor"
                  required
                />
                <div v-if="!validateCodProveedor() && form.codProveedor.length > 0" class="text-red-500 text-sm">
                  * El código debe ser un número de entre 8 y 12 dígitos.
                </div>
              </div>

              <!-- Nombre -->
              <div class="mb-4">
                <InputLabel for="nombre" value="Nombre" />
                <InputError :message="errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  class="mt-1 block w-full"
                  placeholder="Ingrese el nombre del proveedor"
                  required
                />
                <div v-if="!validateNombre() && form.nombre.length > 0" class="text-red-500 text-sm">
                  * El nombre debe tener entre 3 y 30 caracteres.
                </div>
              </div>

              <!-- Dirección -->
              <div class="mb-4">
                <InputLabel for="direccion" value="Dirección" />
                <InputError :message="errors.direccion" />
                <TextInput
                  v-model="form.direccion"
                  id="direccion"
                  class="mt-1 block w-full"
                  placeholder="Ingrese la dirección del proveedor"
                  required
                />
                <div v-if="!validateDireccion() && form.direccion.length > 0" class="text-red-500 text-sm">
                  * La dirección debe tener entre 6 y 200 caracteres.
                </div>
              </div>

              <!-- Teléfono -->
              <div class="mb-4">
                <InputLabel for="telefono" value="Teléfono" />
                <InputError :message="errors.telefono" />
                <TextInput
                  v-model="form.telefono"
                  id="telefono"
                  class="mt-1 block w-full"
                  placeholder="Ingrese el teléfono del proveedor"
                  required
                />
                <div v-if="!validateTelefono() && form.telefono.length > 0" class="text-red-500 text-sm">
                  * El teléfono debe ser un número de entre 8 y 10 dígitos.
                </div>
              </div>

              <div class="text-center">
                <!-- Botón Atrás -->
                <Link href="{{ route('proveedor.index') }}" class="btn btn-secondary me-3">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>

                <!-- Botón Guardar -->
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

