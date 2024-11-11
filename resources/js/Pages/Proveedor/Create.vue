<script setup>
import { ref, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Recibiendo propiedades desde Inertia
const props = defineProps({
    errors: Object,
});

// Formulario para registrar el proveedor
const form = useForm({
    codProveedor: '', // Código del proveedor
    nombre: '', // Nombre del proveedor
    direccion: '', // Dirección del proveedor
    telefono: '', // Teléfono del proveedor
});

// Referencia al botón de submit para habilitar/deshabilitar
const submitButton = ref(null);

// Función para validar el código del proveedor
const validateCodProveedor = () => {
    const codProveedor = form.codProveedor.trim();
    const isValid = /^\d{8,12}$/.test(codProveedor); // Código entre 8 y 12 dígitos
    return isValid;
};

// Función para validar el nombre del proveedor
const validateNombre = () => {
    const nombre = form.nombre.trim();
    const isValid = nombre.length > 2 && nombre.length < 31; // Nombre entre 3 y 30 caracteres
    return isValid;
};

// Función para validar la dirección del proveedor
const validateDireccion = () => {
    const direccion = form.direccion.trim();
    const isValid = direccion.length > 5 && direccion.length < 201; // Dirección entre 6 y 200 caracteres
    return isValid;
};

// Función para validar el teléfono del proveedor
const validateTelefono = () => {
    const telefono = form.telefono.trim();
    const isValid = /^\d{8,10}$/.test(telefono); // Teléfono entre 8 y 10 dígitos
    return isValid;
};

// Función para habilitar o deshabilitar el botón de envío
const validateForm = () => {
    submitButton.value.disabled = !(validateCodProveedor() && validateNombre() && validateDireccion() && validateTelefono());
};

// Función para manejar el envío del formulario
const submit = () => {
    form.post(route('proveedor.store'), {
        onSuccess: () => {
            // Redirigir al listado de proveedores en caso de éxito
            router.get(route('proveedor.index'));
        },
    });
};

// Verificar la validación de los campos al cargar y al escribir
watch(
    () => form.codProveedor,
    () => {
        validateForm();
    }
);
watch(
    () => form.nombre,
    () => {
        validateForm();
    }
);
watch(
    () => form.direccion,
    () => {
        validateForm();
    }
);
watch(
    () => form.telefono,
    () => {
        validateForm();
    }
);
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
                            <!-- Código Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="codProveedor" value="Código" />
                                <InputError :message="errors.codProveedor" />
                                <TextInput
                                    v-model="form.codProveedor"
                                    id="codProveedor"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el código del proveedor"
                                    required
                                    @input="validateForm"
                                />
                                <div v-if="!validateCodProveedor() && form.codProveedor.length > 0" class="text-red-500 text-sm">
                                    * El código debe ser un número de entre 8 y 12 dígitos.
                                </div>
                            </div>

                            <!-- Nombre Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="nombre" value="Nombre" />
                                <InputError :message="errors.nombre" />
                                <TextInput
                                    v-model="form.nombre"
                                    id="nombre"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el nombre del proveedor"
                                    required
                                    @input="validateForm"
                                />
                                <div v-if="!validateNombre() && form.nombre.length > 0" class="text-red-500 text-sm">
                                    * El nombre debe tener entre 3 y 30 caracteres.
                                </div>
                            </div>

                            <!-- Dirección Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="direccion" value="Dirección" />
                                <InputError :message="errors.direccion" />
                                <TextInput
                                    v-model="form.direccion"
                                    id="direccion"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese la dirección del proveedor"
                                    required
                                    @input="validateForm"
                                />
                                <div v-if="!validateDireccion() && form.direccion.length > 0" class="text-red-500 text-sm">
                                    * La dirección debe tener entre 6 y 200 caracteres.
                                </div>
                            </div>

                            <!-- Teléfono Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="telefono" value="Teléfono" />
                                <InputError :message="errors.telefono" />
                                <TextInput
                                    v-model="form.telefono"
                                    id="telefono"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el teléfono del proveedor"
                                    required
                                    @input="validateForm"
                                />
                                <div v-if="!validateTelefono() && form.telefono.length > 0" class="text-red-500 text-sm">
                                    * El teléfono debe ser un número de entre 8 y 10 dígitos.
                                </div>
                            </div>

                            <div class="text-center">
                                <Link :href=" route('proveedor.index') ">
                                   Atrás
                                </Link>

                                <!-- Botón de Enviar -->
                                <PrimaryButton
                                    ref="submitButton"
                                    class="mt-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="!validateCodProveedor() || !validateNombre() || !validateDireccion() || !validateTelefono() || form.processing"
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
