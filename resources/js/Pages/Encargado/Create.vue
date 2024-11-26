<script setup>
import { ref, computed, watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue'; 
import VisitaFooter from '@/Components/VisitaFooter.vue';

const props = defineProps({
  vendedores: Object, 
  sessionSuccess: String,
  errors: Object
});

const form = useForm({
  carnetIdentidad: '',
  nombre: '',
  apellidoPaterno: '',
  apellidoMaterno: '',
  sexo: '',
  edad: '',
  telefono: '',
  nombreUsuario: '',
  email: '',
  password: ''
});

const errorMessages = ref({
  carnetIdentidad: '',
  nombre: '',
  apellidoPaterno: '',
  apellidoMaterno: '',
  sexo: '',
  edad: '',
  telefono: '',
  nombreUsuario: '',
  email: '',
  password: ''
});

// Validación en tiempo real de cada campo
watch(() => form.carnetIdentidad, () => {
  errorMessages.value.carnetIdentidad = form.carnetIdentidad.length < 8 || form.carnetIdentidad.length > 10
    ? 'La cédula de identidad debe tener entre 8 y 10 caracteres.'
    : '';
});

watch(() => form.nombre, () => {
  errorMessages.value.nombre = form.nombre.length < 3
    ? 'El nombre debe tener al menos 3 caracteres.'
    : '';
});

watch(() => form.apellidoPaterno, () => {
  errorMessages.value.apellidoPaterno = form.apellidoPaterno.length < 3
    ? 'El apellido paterno debe tener al menos 3 caracteres.'
    : '';
});

watch(() => form.apellidoMaterno, () => {
  errorMessages.value.apellidoMaterno = form.apellidoMaterno.length < 3
    ? 'El apellido materno debe tener al menos 3 caracteres.'
    : '';
});

watch(() => form.sexo, () => {
  errorMessages.value.sexo = form.sexo ? '' : 'El sexo es obligatorio.';
});

watch(() => form.edad, () => {
  errorMessages.value.edad = (form.edad < 18 || form.edad > 60)
    ? 'La edad debe estar entre 18 y 60 años.'
    : '';
});

watch(() => form.telefono, () => {
  errorMessages.value.telefono = form.telefono.length < 8 || form.telefono.length > 10
    ? 'El teléfono debe tener entre 8 y 10 caracteres.'
    : '';
});

watch(() => form.nombreUsuario, () => {
  errorMessages.value.nombreUsuario = form.nombreUsuario.length < 3
    ? 'El nombre de usuario debe tener al menos 3 caracteres.'
    : '';
});

watch(() => form.email, () => {
  errorMessages.value.email = !form.email.includes('@')
    ? 'El correo electrónico debe ser válido.'
    : '';
});

watch(() => form.password, () => {
  errorMessages.value.password = form.password.length < 8
    ? 'La contraseña debe tener al menos 8 caracteres.'
    : '';
});

const submit = () => {
  form.post(route('encargado.store'));
};

const togglePasswordVisibility = () => {
  const passwordField = document.getElementById('password');
  passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
};
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <AppLayout title="Registrar Encargado">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registrar Encargado
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Registrar Encargado</h1>

            <form @submit.prevent="submit">
              <!-- Cédula de Identidad -->
              <div class="mb-4">
                <InputLabel for="carnetIdentidad" value="Cédula de Identidad" class="bb" />
                <TextInput
                  v-model="form.carnetIdentidad"
                  id="carnetIdentidad"
                  type="text"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese la cédula de identidad"
                  required
                />
                <div v-if="errorMessages.carnetIdentidad" class="text-red-500 text-sm dd">
                  {{ errorMessages.carnetIdentidad }}
                </div>
              </div>

              <!-- Nombre -->
              <div class="mb-4">
                <InputLabel for="nombre" value="Nombre" class="bb" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  type="text"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el nombre"
                  required
                />
                <div v-if="errorMessages.nombre" class="text-red-500 text-sm dd">
                  {{ errorMessages.nombre }}
                </div>
              </div>

              <!-- Apellido Paterno -->
              <div class="mb-4">
                <InputLabel for="apellidoPaterno" value="Apellido Paterno" class="bb" />
                <TextInput
                  v-model="form.apellidoPaterno"
                  id="apellidoPaterno"
                  type="text"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el apellido paterno"
                  required
                />
                <div v-if="errorMessages.apellidoPaterno" class="text-red-500 text-sm dd">
                  {{ errorMessages.apellidoPaterno }}
                </div>
              </div>

              <!-- Apellido Materno -->
              <div class="mb-4">
                <InputLabel for="apellidoMaterno" value="Apellido Materno" class="bb" />
                <TextInput
                  v-model="form.apellidoMaterno"
                  id="apellidoMaterno"
                  type="text"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el apellido materno"
                  required
                />
                <div v-if="errorMessages.apellidoMaterno" class="text-red-500 text-sm dd">
                  {{ errorMessages.apellidoMaterno }}
                </div>
              </div>

              <!-- Sexo -->
              <div class="mb-4">
                <InputLabel for="sexo" value="Sexo" class="bb" />
                <select
                  v-model="form.sexo"
                  id="sexo"
                  class="mt-1 block w-full cc"
                  required
                >
                  <option value="">Selecciona el sexo</option>
                  <option value="masculino">Masculino</option>
                  <option value="femenino">Femenino</option>
                </select>
                <div v-if="errorMessages.sexo" class="text-red-500 text-sm dd">
                  {{ errorMessages.sexo }}
                </div>
              </div>

              <!-- Edad -->
              <div class="mb-4">
                <InputLabel for="edad" value="Edad" class="bb" />
                <TextInput
                  v-model="form.edad"
                  id="edad"
                  type="number"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese la edad"
                  required
                />
                <div v-if="errorMessages.edad" class="text-red-500 text-sm dd">
                  {{ errorMessages.edad }}
                </div>
              </div>

              <!-- Teléfono -->
              <div class="mb-4">
                <InputLabel for="telefono" value="Teléfono" class="bb" />
                <TextInput
                  v-model="form.telefono"
                  id="telefono"
                  type="tel"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el teléfono"
                  required
                />
                <div v-if="errorMessages.telefono" class="text-red-500 text-sm dd">
                  {{ errorMessages.telefono }}
                </div>
              </div>

              <!-- Correo Electrónico -->
              <div class="mb-4">
                <InputLabel for="email" value="Correo Electrónico" class="bb" />
                <TextInput
                  v-model="form.email"
                  id="email"
                  type="email"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el correo electrónico"
                  required
                />
                <div v-if="errorMessages.email" class="text-red-500 text-sm dd">
                  {{ errorMessages.email }}
                </div>
              </div>

              <!-- Nombre de Usuario -->
              <div class="mb-4">
                <InputLabel for="nombreUsuario" value="Nombre de Usuario" class="bb" />
                <TextInput
                  v-model="form.nombreUsuario"
                  id="nombreUsuario"
                  type="text"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el nombre de usuario"
                  required
                />
                <div v-if="errorMessages.nombreUsuario" class="text-red-500 text-sm dd">
                  {{ errorMessages.nombreUsuario }}
                </div>
              </div>

              <!-- Contraseña -->
              <div class="mb-4">
                <InputLabel for="password" value="Contraseña" class="bb" />
                <div class="relative">
                  <TextInput
                    v-model="form.password"
                    id="password"
                    type="password"
                    class="mt-1 block w-full cc"
                    placeholder="Ingrese la contraseña"
                    required
                  />
                  <button
                    type="button"
                    class="absolute top-0 right-0 mt-1 mr-3 text-gray-600"
                    @click="togglePasswordVisibility"
                  >
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                <div v-if="errorMessages.password" class="text-red-500 text-sm dd">
                  {{ errorMessages.password }}
                </div>
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary me-2 ff">
    <i class="fas fa-arrow-left"></i> Atrás
</button>

                <PrimaryButton
                  type="submit"
                  class="mt-4 btn-primary ff"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
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
