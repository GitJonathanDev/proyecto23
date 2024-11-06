<script setup>
import { ref, watch, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

// Formulario reactivo
const form = useForm({
    nombreUsuario: '',
    email: '',
    password: '',
    codTipoUsuarioF: '',
});

// Errores de validación (vienen desde Inertia)
const props = defineProps({
    errors: Object,
    tiposUsuario: Array,
});

// Validación de cada campo
const isNombreUsuarioValid = computed(() => form.nombreUsuario.length > 3);
const isEmailValid = computed(() => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email));
const isPasswordValid = computed(() => form.password.length >= 8);
const isCodTipoUsuarioFValid = computed(() => form.codTipoUsuarioF !== '');

// Habilitar o deshabilitar el botón de envío
const isFormValid = computed(() => 
    isNombreUsuarioValid.value &&
    isEmailValid.value &&
    isPasswordValid.value &&
    isCodTipoUsuarioFValid.value
);

// Función para manejar el envío del formulario
const submit = () => {
    form.post(route('usuario.store'), {
        onSuccess: () => {
            // Redirigir al listado de usuarios en caso de éxito
            router.get(route('usuario.index'));
        },
    });
};
</script>

<template>
    <AppLayout title="Registrar Usuario">
        <template #header>
            <!-- Título principal agregado -->
            <h1 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
                Registrar Usuario
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" novalidate>
                            <!-- Nombre de Usuario -->
                            <div class="mb-4">
                                <InputLabel for="nombreUsuario" value="Nombre" />
                                <InputError :message="props.errors.nombreUsuario" />
                                <TextInput 
                                    v-model="form.nombreUsuario"
                                    id="nombreUsuario"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el nombre de usuario"
                                    required
                                />
                                <div v-if="!isNombreUsuarioValid && form.nombreUsuario.length > 0" class="text-red-500 text-sm">
                                    * El nombre de usuario debe tener más de 3 caracteres.
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <InputLabel for="email" value="Email" />
                                <InputError :message="props.errors.email" />
                                <TextInput 
                                    v-model="form.email"
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el email"
                                    required
                                />
                                <div v-if="!isEmailValid && form.email.length > 0" class="text-red-500 text-sm">
                                    * El correo electrónico debe tener un formato válido.
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-4 relative">
                                <InputLabel for="password" value="Contraseña" />
                                <InputError :message="props.errors.password" />
                                <TextInput 
                                    v-model="form.password"
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese la contraseña"
                                    required
                                />
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary position-absolute right-0 top-1/2 transform -translate-y-1/2"
                                    @click="form.password = form.password ? '' : form.password"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div v-if="!isPasswordValid && form.password.length > 0" class="text-red-500 text-sm">
                                    * La contraseña debe tener al menos 8 caracteres.
                                </div>
                            </div>

                            <!-- Tipo de Usuario -->
                            <div class="mb-4">
                                <InputLabel for="codTipoUsuarioF" value="Tipo de Usuario" />
                                <InputError :message="props.errors.codTipoUsuarioF" />
                                <select 
                                    v-model="form.codTipoUsuarioF"
                                    id="codTipoUsuarioF"
                                    class="form-select mt-1 w-full"
                                    required
                                >
                                    <option value="" disabled>Seleccionar tipo de usuario</option>
                                    <option v-for="tipo in props.tiposUsuario" :key="tipo.codTipoUsuario" :value="tipo.codTipoUsuario">
                                        {{ tipo.descripcion }}
                                    </option>
                                </select>
                                <div v-if="!isCodTipoUsuarioFValid && form.codTipoUsuarioF.length === 0" class="text-red-500 text-sm">
                                    * Debes seleccionar un tipo de usuario.
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="text-center">
                                <Link href="{{ route('usuario.index') }}" class="btn btn-secondary me-3">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>
                                <PrimaryButton 
                                    class="mt-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="!isFormValid || form.processing"
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
