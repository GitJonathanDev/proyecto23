<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { defineProps } from 'vue';

// Propiedades recibidas
const props = defineProps({
  vendedor: Object,
  errors: Object
});

// Inicializamos el formulario con los datos del vendedor
const form = useForm({
  carnetIdentidad: props.vendedor.carnetIdentidad || '',
  nombre: props.vendedor.nombre || '',
  apellidoPaterno: props.vendedor.apellidoPaterno || '',
  apellidoMaterno: props.vendedor.apellidoMaterno || '',
  sexo: props.vendedor.sexo || '',
  telefono: props.vendedor.telefono || ''
});

// Función para manejar el envío del formulario
const submit = () => {
  form.put(route('vendedor.update', props.vendedor.carnetIdentidad));
};

// Validaciones de los campos
const validateCarnetIdentidad = () => {
  return /^\d{8,10}$/.test(form.carnetIdentidad);
};
const validateNombre = () => {
  return /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(form.nombre);
};
const validateApellidoPaterno = () => {
  return /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(form.apellidoPaterno);
};
const validateApellidoMaterno = () => {
  return /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(form.apellidoMaterno);
};
const validateTelefono = () => {
  return /^\d{8,10}$/.test(form.telefono);
};

// Estado para verificar si el formulario es válido
const isFormValid = () => {
  return (
    validateCarnetIdentidad() &&
    validateNombre() &&
    validateApellidoPaterno() &&
    validateApellidoMaterno() &&
    form.sexo !== '' &&
    validateTelefono()
  );
};
</script>

<template>
  <AppLayout title="Editar Vendedor">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Vendedor
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <!-- Errores del formulario -->
            <div v-if="form.errors" class="alert alert-danger">
              <ul>
                <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
              </ul>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit">
              <!-- Cédula de Identidad -->
              <div class="mb-3">
                <InputLabel for="carnetIdentidad" value="Cédula de Identidad" />
                <InputError :message="form.errors.carnetIdentidad" />
                <TextInput
                  v-model="form.carnetIdentidad"
                  id="carnetIdentidad"
                  class="form-control"
                  type="text"
                  placeholder="Ingrese la cédula de identidad"
                  required
                />
              </div>

              <!-- Nombre -->
              <div class="mb-3">
                <InputLabel for="nombre" value="Nombre" />
                <InputError :message="form.errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  class="form-control"
                  type="text"
                  placeholder="Ingrese el nombre"
                  required
                />
              </div>

              <!-- Apellido Paterno -->
              <div class="mb-3">
                <InputLabel for="apellidoPaterno" value="Apellido Paterno" />
                <InputError :message="form.errors.apellidoPaterno" />
                <TextInput
                  v-model="form.apellidoPaterno"
                  id="apellidoPaterno"
                  class="form-control"
                  type="text"
                  placeholder="Ingrese el apellido paterno"
                  required
                />
              </div>

              <!-- Apellido Materno -->
              <div class="mb-3">
                <InputLabel for="apellidoMaterno" value="Apellido Materno" />
                <InputError :message="form.errors.apellidoMaterno" />
                <TextInput
                  v-model="form.apellidoMaterno"
                  id="apellidoMaterno"
                  class="form-control"
                  type="text"
                  placeholder="Ingrese el apellido materno"
                  required
                />
              </div>

              <!-- Sexo -->
              <div class="mb-3">
                <InputLabel for="sexo" value="Sexo" />
                <InputError :message="form.errors.sexo" />
                <select
                  v-model="form.sexo"
                  id="sexo"
                  class="form-control"
                  required
                >
                  <option value="">Seleccione el sexo</option>
                  <option value="masculino" :selected="form.sexo === 'masculino'">Masculino</option>
                  <option value="femenino" :selected="form.sexo === 'femenino'">Femenino</option>
                </select>
              </div>

              <!-- Teléfono -->
              <div class="mb-3">
                <InputLabel for="telefono" value="Teléfono" />
                <InputError :message="form.errors.telefono" />
                <TextInput
                  v-model="form.telefono"
                  id="telefono"
                  class="form-control"
                  type="tel"
                  placeholder="Ingrese el teléfono"
                  required
                />
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link
                  href="{{ route('vendedor.index') }}"
                  class="btn btn-secondary me-2"
                >
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  type="submit"
                  :disabled="!isFormValid() || form.processing"
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
