<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue'; 

// Recibimos los datos de la sesión y errores del padre
const props = defineProps({
  sessionSuccess: String,
  errors: Object
});

// Inicializamos el formulario
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

// Función para manejar el envío del formulario
const submit = () => {
  form.post(route('encargado.store'));
};

// Validación del cliente
const validateForm = () => {
  return (
    form.carnetIdentidad.length >= 8 &&
    form.carnetIdentidad.length <= 10 &&
    form.nombre.length >= 3 &&
    form.apellidoPaterno.length >= 3 &&
    form.apellidoMaterno.length >= 3 &&
    form.sexo &&
    form.edad >= 8 && form.edad <= 100 &&
    form.telefono.length >= 8 && form.telefono.length <= 10 &&
    form.nombreUsuario.length > 3 &&
    form.email.includes('@') &&
    form.password.length > 8
  );
};

const togglePasswordVisibility = () => {
  const passwordField = document.getElementById('password');
  passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
};
</script>

<template>
  <plantillanav/>
  <AppLayout title="Registrar Vendedor">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registrar Encargado
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <!-- Alerta de éxito -->
            <div v-if="props.sessionSuccess" class="alert alert-success">
              {{ props.sessionSuccess }}
            </div>

            <!-- Errores de validación -->
            <div v-if="form.errors" class="alert alert-danger">
              <p v-for="(error, field) in form.errors" :key="field">{{ error }}</p>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit">
              <div class="form-group row mb-3">
                <InputLabel for="carnetIdentidad" value="Cédula de identidad" />
                <InputError :message="form.errors.carnetIdentidad" />
                <TextInput
                  v-model="form.carnetIdentidad"
                  id="carnetIdentidad"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Ingrese la cédula de identidad"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="nombre" value="Nombre" />
                <InputError :message="form.errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Ingrese el nombre"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="apellidoPaterno" value="Apellido Paterno" />
                <InputError :message="form.errors.apellidoPaterno" />
                <TextInput
                  v-model="form.apellidoPaterno"
                  id="apellidoPaterno"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Ingrese el apellido paterno"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="apellidoMaterno" value="Apellido Materno" />
                <InputError :message="form.errors.apellidoMaterno" />
                <TextInput
                  v-model="form.apellidoMaterno"
                  id="apellidoMaterno"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Ingrese el apellido materno"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="sexo" value="Sexo" />
                <InputError :message="form.errors.sexo" />
                <select
                  v-model="form.sexo"
                  id="sexo"
                  class="form-control"
                  required
                >
                  <option value="">Selecciona el sexo</option>
                  <option value="masculino">Masculino</option>
                  <option value="femenino">Femenino</option>
                </select>
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="edad" value="Edad" />
                <InputError :message="form.errors.edad" />
                <TextInput
                  v-model="form.edad"
                  id="edad"
                  type="number"
                  class="form-control"
                  required
                  placeholder="Ingrese la edad"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="telefono" value="Teléfono" />
                <InputError :message="form.errors.telefono" />
                <TextInput
                  v-model="form.telefono"
                  id="telefono"
                  type="tel"
                  class="form-control"
                  required
                  placeholder="Ingrese el teléfono"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="nombreUsuario" value="Nombre de Usuario" />
                <InputError :message="form.errors.nombreUsuario" />
                <TextInput
                  v-model="form.nombreUsuario"
                  id="nombreUsuario"
                  type="text"
                  class="form-control"
                  required
                  placeholder="Ingrese el nombre de usuario"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="email" value="Correo Electrónico" />
                <InputError :message="form.errors.email" />
                <TextInput
                  v-model="form.email"
                  id="email"
                  type="email"
                  class="form-control"
                  required
                  placeholder="Ingrese el correo electrónico"
                />
              </div>

              <div class="form-group row mb-3">
                <InputLabel for="password" value="Contraseña" />
                <InputError :message="form.errors.password" />
                <div class="position-relative">
                  <TextInput
                    v-model="form.password"
                    id="password"
                    type="password"
                    class="form-control"
                    required
                    placeholder="Ingrese la contraseña"
                  />
                  <button
                    type="button"
                    class="btn btn-outline-secondary position-absolute"
                    style="top: 50%; right: 0; transform: translateY(-50%);"
                    @click="togglePasswordVisibility"
                  >
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link
                  :href="route('encargado.index')"
                  class="btn btn-secondary me-2"
                >
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  :disabled="!validateForm() || form.processing"
                  type="submit"
                  class="btn btn-primary"
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
