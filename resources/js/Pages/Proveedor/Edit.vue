<script setup>
import { ref, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Propiedades recibidas desde el controlador
const props = defineProps({
  proveedor: Object,
  errors: Object,
});

// Inicializamos el formulario con los datos del proveedor
const form = useForm({
  nombre: props.proveedor?.nombre || '',
  direccion: props.proveedor?.direccion || '',
  telefono: props.proveedor?.telefono || '',
});

// Referencia al botón de submit para habilitar/deshabilitar
const submitButton = ref(null);

// Funciones de validación
const validateNombre = () => form.nombre.length > 2 && form.nombre.length < 31;
const validateDireccion = () => form.direccion.length > 5 && form.direccion.length < 201;
const validateTelefono = () => /^\d{8,10}$/.test(form.telefono);

// Función para habilitar o deshabilitar el botón de envío
const validateForm = () => {
  submitButton.value.disabled = !(validateNombre() && validateDireccion() && validateTelefono());
};

// Función para manejar el envío del formulario
const submit = () => {
  form.put(route('proveedor.update', props.proveedor.codProveedor), {
    onSuccess: () => {
      // Redirigir al listado de proveedores en caso de éxito
      router.get(route('proveedor.index'));
    },
  });
};

// Verificar la validación de los campos al cargar y al escribir
watch([() => form.nombre, () => form.direccion, () => form.telefono], () => {
  validateForm();
});
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <AppLayout title="Editar Proveedor">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Proveedor
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Editar Proveedor</h1>

            <!-- Errores de validación -->
            <div v-if="form.errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in form.errors" :key="index">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit" novalidate>
              <!-- Nombre -->
              <div class="mb-4">
                <InputLabel for="nombre" value="Nombre" class="bb" />
                <InputError :message="form.errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el nombre del proveedor"
                  required
                  @input="validateForm"
                />
                <div v-if="!validateNombre() && form.nombre.length > 0" class="text-red-500 text-sm dd">
                  * El nombre debe tener entre 3 y 30 caracteres.
                </div>
              </div>

              <!-- Dirección -->
              <div class="mb-4">
                <InputLabel for="direccion" value="Dirección" class="bb" />
                <InputError :message="form.errors.direccion" />
                <TextInput
                  v-model="form.direccion"
                  id="direccion"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese la dirección del proveedor"
                  required
                  @input="validateForm"
                />
                <div v-if="!validateDireccion() && form.direccion.length > 0" class="text-red-500 text-sm dd">
                  * La dirección debe tener entre 6 y 200 caracteres.
                </div>
              </div>

              <!-- Teléfono -->
              <div class="mb-4">
                <InputLabel for="telefono" value="Teléfono" class="bb" />
                <InputError :message="form.errors.telefono" />
                <TextInput
                  v-model="form.telefono"
                  id="telefono"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el teléfono del proveedor"
                  required
                  @input="validateForm"
                />
                <div v-if="!validateTelefono() && form.telefono.length > 0" class="text-red-500 text-sm dd">
                  * El teléfono debe ser un número de entre 8 y 10 dígitos.
                </div>
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link :href="route('proveedor.index')" class="btn btn-secondary me-3">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  ref="submitButton"
                  class="btn btn-primary"
                  :disabled="!validateNombre() || !validateDireccion() || !validateTelefono() || form.processing"
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
