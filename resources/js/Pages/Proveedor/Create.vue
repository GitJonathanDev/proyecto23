<script setup>
import { ref, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

// Recibiendo propiedades desde Inertia
const props = defineProps({
    errors: Object,
});

// Formulario para registrar el proveedor
const form = useForm({
    codProveedor: '', // Código del proveedor
    nombre: '',       // Nombre del proveedor
    direccion: '',    // Dirección del proveedor
    telefono: '',     // Teléfono del proveedor
});

// Referencia al botón de submit para habilitar/deshabilitar
const submitButton = ref(null);

// Función para validar el código del proveedor
const validateCodProveedor = () => {
    const codProveedor = form.codProveedor.trim();
    return /^\d{8,12}$/.test(codProveedor); 
};

// Función para validar el nombre del proveedor
const validateNombre = () => {
    const nombre = form.nombre.trim();
    return nombre.length > 2 && nombre.length < 31; 
};

// Función para validar la dirección del proveedor
const validateDireccion = () => {
    const direccion = form.direccion.trim();
    return direccion.length > 5 && direccion.length < 201; 
};

// Función para validar el teléfono del proveedor
const validateTelefono = () => {
    const telefono = form.telefono.trim();
    return /^\d{8,10}$/.test(telefono); 
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

watch(
    () => [form.codProveedor, form.nombre, form.direccion, form.telefono],
    validateForm
);
</script>

<template>
    <plantillanav :userName="$page.props.auth.user.name" />
    <AppLayout title="Registrar Proveedor">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Proveedor
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
                    <div class="p-6 lg:p-8 border-gray-200 divpequeno">
                        <h1 class="text-2xl font-bold text-center mb-6">Registrar Proveedor</h1>
                        <form @submit.prevent="submit" novalidate>
                            <!-- Código del Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="codProveedor" value="Código del Proveedor" class="bb" />
                                <InputError :message="errors.codProveedor" />
                                <TextInput
                                    v-model="form.codProveedor"
                                    id="codProveedor"
                                    class="mt-1 block w-full cc"
                                    placeholder="Ingrese el código del proveedor"
                                    required
                                    @input="validateForm"
                                />
                                <div v-if="!validateCodProveedor() && form.codProveedor.length > 0" class="text-red-500 text-sm dd">
                                    * El código debe ser un número de entre 8 y 12 dígitos.
                                </div>
                            </div>

                            <!-- Nombre del Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="nombre" value="Nombre" class="bb" />
                                <InputError :message="errors.nombre" />
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

                            <!-- Dirección del Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="direccion" value="Dirección" class="bb" />
                                <InputError :message="errors.direccion" />
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

                            <!-- Teléfono del Proveedor -->
                            <div class="mb-4">
                                <InputLabel for="telefono" value="Teléfono" class="bb" />
                                <InputError :message="errors.telefono" />
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

                            <div class="text-center">
                                <Link href="{{ route('proveedor.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>
                                <PrimaryButton
                                    ref="submitButton"
                                    class="mt-4 btn-primary"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="!validateCodProveedor() || form.processing"
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
  margin-top: calc(10px + 1rem);
}
</style>
