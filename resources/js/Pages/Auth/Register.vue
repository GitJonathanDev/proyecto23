<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    carnet_identidad: '',  
    nombre: '',
    name: '',
    apellido_paterno: '',
    apellido_materno: '',
    sexo: '',
    telefono: '',
    edad: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registro" />

    <div class="background">
        <AuthenticationCard class="auth-card">
            <h2 class="text-center text-2xl font-bold mb-6">REGISTRAR</h2>

            <form @submit.prevent="submit">
                <!-- Campo Carnet de Identidad -->
                <div>
                    <InputLabel for="carnet_identidad" value="Carnet de Identidad" />
                    <TextInput
                        id="carnet_identidad"
                        v-model="form.carnet_identidad"
                        type="text"
                        class="input-field"
                        required
                        autocomplete="off"
                    />
                    <InputError class="mt-2" :message="form.errors.carnet_identidad" />
                </div>

                <!-- Campo Nombre -->
                <div class="mt-4">
                    <InputLabel for="nombre" value="Nombre" />
                    <TextInput
                        id="nombre"
                        v-model="form.nombre"
                        type="text"
                        class="input-field"
                        required
                        autofocus
                        autocomplete="nombre"
                    />
                    <InputError class="mt-2" :message="form.errors.nombre" />
                </div>

                <!-- Campo Apellido Paterno -->
                <div class="mt-4">
                    <InputLabel for="apellido_paterno" value="Apellido Paterno" />
                    <TextInput
                        id="apellido_paterno"
                        v-model="form.apellido_paterno"
                        type="text"
                        class="input-field"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.apellido_paterno" />
                </div>

                <!-- Campo Apellido Materno -->
                <div class="mt-4">
                    <InputLabel for="apellido_materno" value="Apellido Materno" />
                    <TextInput
                        id="apellido_materno"
                        v-model="form.apellido_materno"
                        type="text"
                        class="input-field"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.apellido_materno" />
                </div>

                <!-- Campo Sexo -->
                <div class="mt-4">
                    <InputLabel for="sexo" value="Sexo" />
                    <select
                        id="sexo"
                        v-model="form.sexo"
                        class="input-field select-field"
                        required
                    >
                        <option value="">Seleccione...</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.sexo" />
                </div>

                <!-- Campo Teléfono -->
                <div class="mt-4">
                    <InputLabel for="telefono" value="Teléfono" />
                    <TextInput
                        id="telefono"
                        v-model="form.telefono"
                        type="text"
                        class="input-field"
                        required
                        autocomplete="tel"
                    />
                    <InputError class="mt-2" :message="form.errors.telefono" />
                </div>

                <!-- Campo Nombre de Usuario -->
                <div class="mt-4">
                    <InputLabel for="name" value="Nombre de usuario" />
                    <TextInput
                        id="name"
                        v-model="form.name"   
                        type="text"
                        class="input-field"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <!-- Campo Edad -->
                <div class="mt-4">
                    <InputLabel for="edad" value="Edad" />
                    <TextInput
                        id="edad"
                        v-model="form.edad"
                        type="number"
                        class="input-field"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.edad" />
                </div>

                <!-- Campo Correo Electrónico -->
                <div class="mt-4">
                    <InputLabel for="email" value="Correo Electrónico" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="input-field"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Campo Contraseña -->
                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="input-field"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Campo Confirmar Contraseña -->
                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="input-field"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <!-- Términos y Condiciones -->
                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                    <InputLabel for="terms">
                        <div class="flex items-center">
                            <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />
                            <div class="ml-2">
                                Acepto los <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Términos de Servicio</a> y la <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Política de Privacidad</a>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.terms" />
                    </InputLabel>
                </div>

                <!-- Botón de registro -->
                <div class="flex items-center justify-end mt-6">
                    <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        ¿Ya estás registrado?
                    </Link>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Registrarse
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticationCard>
    </div>
</template>

<style scoped>
.background {
    background-image: url('img/fondo.jpg');
    background-repeat: repeat; /* Hace que la imagen de fondo se repita */
    background-size: auto; /* Ajusta la imagen sin distorsionarla */
    background-position: center; 
    height: 100vh; 
    display: flex;
    align-items: center; 
    justify-content: center;
    overflow: auto; /* Permite el desplazamiento si el contenido excede el tamaño de la pantalla */
}

.auth-card {
    padding: 2rem; /* Espaciado alrededor del contenido */
    border-radius: 0.5rem; /* Bordes redondeados */
    width: 90%; /* Ancho adaptable */
    max-width: 400px; /* Máximo ancho */
    overflow: auto; /* Permite el desplazamiento dentro del formulario si es necesario */
}

.input-field,
.select-field {
    margin-top: 0.5rem;
    padding: 0.75rem; /* Espaciado interno */
    border: 1px solid #d1d5db; /* Color de borde */
    border-radius: 0.375rem; /* Bordes redondeados */
    transition: border-color 0.3s; /* Transición suave para el borde */
    width: 100%; /* Aseguramos que el select ocupe todo el ancho disponible */
}

.input-field:focus,
.select-field:focus {
    border-color: #4f46e5; /* Color del borde al enfocar */
    outline: none; /* Sin borde de enfoque predeterminado */
}

h2 {
    color: #333; 
}
</style>
