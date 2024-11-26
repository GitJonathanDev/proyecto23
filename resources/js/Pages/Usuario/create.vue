<script setup>
import { ref, watch, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

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
            router.get(route('usuario.index'));
        },
    });
};
</script>

<template>
    <plantillanav :userName="$page.props.auth.user.name" />
    <AppLayout title="Registrar Usuario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Usuario
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6">Registrar Usuario</h1>
                        <form @submit.prevent="submit" novalidate>
                            <!-- Nombre de Usuario -->
                            <div class="mb-4">
                                <InputLabel for="nombreUsuario" value="Nombre" class="bb" />
                                <InputError :message="props.errors.nombreUsuario" />
                                <TextInput
                                    v-model="form.nombreUsuario"
                                    id="nombreUsuario"
                                    class="mt-1 block w-full cc"
                                    placeholder="Ingrese el nombre de usuario"
                                    required
                                />
                                <div v-if="!isNombreUsuarioValid && form.nombreUsuario.length > 0" class="text-red-500 text-sm dd">
                                    * El nombre de usuario debe tener más de 3 caracteres.
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <InputLabel for="email" value="Email" class="bb" />
                                <InputError :message="props.errors.email" />
                                <TextInput
                                    v-model="form.email"
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full cc"
                                    placeholder="Ingrese el email"
                                    required
                                />
                                <div v-if="!isEmailValid && form.email.length > 0" class="text-red-500 text-sm dd">
                                    * El correo electrónico debe tener un formato válido.
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-4">
                                <InputLabel for="password" value="Contraseña" class="bb" />
                                <InputError :message="props.errors.password" />
                                <TextInput
                                    v-model="form.password"
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full cc"
                                    placeholder="Ingrese la contraseña"
                                    required
                                />
                                <div v-if="!isPasswordValid && form.password.length > 0" class="text-red-500 text-sm dd">
                                    * La contraseña debe tener al menos 8 caracteres.
                                </div>
                            </div>

                            <!-- Tipo de Usuario -->
                            <div class="mb-4">
                                <InputLabel for="codTipoUsuarioF" value="Tipo de Usuario" class="bb" />
                                <InputError :message="props.errors.codTipoUsuarioF" />
                                <select
                                    v-model="form.codTipoUsuarioF"
                                    id="codTipoUsuarioF"
                                    class="form-select mt-1 w-full cc"
                                    required
                                >
                                    <option value="" disabled>Seleccionar tipo de usuario</option>
                                    <option v-for="tipo in props.tiposUsuario" :key="tipo.codTipoUsuario" :value="tipo.codTipoUsuario">
                                        {{ tipo.descripcion }}
                                    </option>
                                </select>
                                <div v-if="!isCodTipoUsuarioFValid && form.codTipoUsuarioF.length === 0" class="text-red-500 text-sm dd">
                                    * Debes seleccionar un tipo de usuario.
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="text-center">
                                <Link href="{{ route('usuario.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>
                                <PrimaryButton
                                    class="mt-4 btn-primary"
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
            <VisitaFooter />
        </div>
    </AppLayout>
</template>

<style scoped>
.py-12 {
    margin-top: calc(60px + 1rem);
}
</style>
