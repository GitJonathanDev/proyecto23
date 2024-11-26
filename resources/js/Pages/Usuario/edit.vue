<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Props: recibir los datos del usuario y errores desde el controlador
const props = defineProps({
  usuario: Object,
  tiposUsuario: Array,
  errors: Object,
});

// Formulario reactivo usando useForm
const form = useForm({
  name: props.usuario?.name || '', 
  email: props.usuario?.email || '',
  password: props.usuario?.password || '',  // Asegúrate de que esto tenga el valor correcto
  codTipoUsuarioF: props.usuario?.codTipoUsuarioF || '',
});

// Propiedad reactiva para mostrar u ocultar la contraseña
const showPassword = ref(false);

// Validaciones en los campos
const isNameValid = computed(() => form.name.length > 3);  // Cambié 'isNombreUsuarioValid' por 'isNameValid'
const isEmailValid = computed(() => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email));
const isPasswordValid = computed(() => form.password.length >= 8 || form.password === '');
const isCodTipoUsuarioFValid = computed(() => form.codTipoUsuarioF !== '');

// Habilitar o deshabilitar el botón de envío
const isFormValid = computed(() => 
  isNameValid.value &&
  isEmailValid.value &&
  isPasswordValid.value &&
  isCodTipoUsuarioFValid.value
);

// Función para enviar el formulario
const submit = () => {
  form.put(route('usuario.update', props.usuario.codUsuario), {
    onSuccess: () => {
      // Redirigir después de éxito, o mostrar un mensaje
    }
  });
};
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <AppLayout title="Modificar Usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Editar Usuario
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Modificar Usuario</h1>

            <!-- Errores del servidor -->
            <div v-if="form.errors.success" class="alert alert-success">
              {{ form.errors.success }}
            </div>

            <!-- Formulario de edición -->
            <form @submit.prevent="submit" novalidate>
              <!-- Nombre de usuario -->
              <div class="mb-4">
                <InputLabel for="name" value="Nombre" class="bb" />
                <InputError :message="form.errors.name" />
                <TextInput
                  v-model="form.name"
                  type="text"
                  id="name"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el nombre de usuario"
                  required
                />
                <div v-if="!isNameValid && form.name.length > 0" class="text-red-500 text-sm dd">
                  * El nombre de usuario debe tener más de 3 caracteres.
                </div>
              </div>

              <!-- Email -->
              <div class="mb-4">
                <InputLabel for="email" value="Email" class="bb" />
                <InputError :message="form.errors.email" />
                <TextInput
                  v-model="form.email"
                  type="email"
                  id="email"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el correo electrónico"
                  required
                />
                <div v-if="!isEmailValid && form.email.length > 0" class="text-red-500 text-sm dd">
                  * El correo electrónico debe tener un formato válido.
                </div>
              </div>

              <div class="mb-4">
                <InputLabel for="password" value="Contraseña" class="bb" />
                <InputError :message="form.errors.password" />
                <div class="input-group">
                  <!-- Cambia el tipo a 'text' si showPassword es verdadero -->
                  <TextInput
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    class="mt-1 block w-full cc"
                    placeholder="Ingrese la contraseña"
                  />
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    @click="showPassword = !showPassword"
                  >
                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                  </button>
                </div>
                <div v-if="!isPasswordValid && form.password.length > 0" class="text-red-500 text-sm dd">
                  * La contraseña debe tener al menos 8 caracteres.
                </div>
              </div>

              <!-- Tipo de Usuario -->
              <div class="mb-4">
                <InputLabel for="codTipoUsuarioF" value="Tipo de Usuario" class="bb" />
                <InputError :message="form.errors.codTipoUsuarioF" />
                <select
                  v-model="form.codTipoUsuarioF"
                  id="codTipoUsuarioF"
                  class="form-select ee"
                  required
                >
                  <option value="" disabled>Seleccionar tipo de usuario</option>
                  <option
                    v-for="tipo in props.tiposUsuario"
                    :key="tipo.codTipoUsuario"
                    :value="tipo.codTipoUsuario"
                  >
                    {{ tipo.descripcion }}
                  </option>
                </select>
                <div v-if="!isCodTipoUsuarioFValid && form.codTipoUsuarioF.length === 0" class="text-red-500 text-sm dd">
                  * Debes seleccionar un tipo de usuario.
                </div>
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link
                  href="{{ route('usuario.index') }}"
                  class="btn btn-secondary me-3"
                >
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  type="submit"
                  :disabled="!isFormValid || form.processing"
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
  margin-top: calc(10px + 1rem); 
}

</style>
