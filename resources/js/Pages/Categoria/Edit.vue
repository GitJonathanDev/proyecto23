<script setup>
import { ref, watch, onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Recibiendo las propiedades desde Inertia (datos de la categoría)
const props = defineProps({
    categoria: Object, // Recibimos la categoría a editar desde Inertia
    errors: Object,    // Recibimos los errores de validación
});

// Inicializamos el formulario con los datos de la categoría
const form = useForm({
    nombre: props.categoria.nombre || '', // Usamos el nombre de la categoría como valor inicial
});

// Referencia al botón de submit para habilitar/deshabilitar
const submitButton = ref(null);

// Función para manejar la validación del nombre
const validateNombre = () => {
    const nombre = form.nombre.trim();
    return nombre.length > 3 && nombre.length < 51; // El nombre debe tener entre 4 y 50 caracteres
};

// Función para habilitar o deshabilitar el botón de envío
const validateForm = () => {
    submitButton.value.disabled = !validateNombre();
};

// Función para manejar el envío del formulario
const submit = () => {
    form.put(route('categoria.update', props.categoria.codCategoria), {
        onSuccess: () => {
            // Redirigir al listado de categorías en caso de éxito
            router.get(route('categoria.index'));
        },
    });
};

// Verificar la validación del campo al cargar y al escribir
watch(() => form.nombre, () => {
    validateForm();
});

// Validar al cargar la página
onMounted(() => {
    validateForm();
});
</script>

<template>
    <plantillanav/>
    <AppLayout title="Modificar Categoría">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Categoría
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" novalidate>
                            <!-- Campo de Nombre -->
                            <div class="mb-4">
                                <InputLabel for="nombre" value="Nombre" />
                                <InputError :message="errors.nombre" />
                                <TextInput 
                                    v-model="form.nombre"
                                    id="nombre"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese el nombre de la categoría"
                                    required
                                    @input="validateForm"
                                />
                                <div v-if="!validateNombre() && form.nombre.length > 0" class="text-red-500 text-sm">
                                    * El nombre debe tener entre 4 y 50 caracteres.
                                </div>
                            </div>

                            <div class="text-center">
                                <!-- Botón de Atrás -->
                                <Link href="{{ route('categoria.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Atrás
                                </Link>

                                <!-- Botón de Enviar -->
                                <PrimaryButton 
                                    ref="submitButton"
                                    class="mt-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="!validateNombre() || form.processing"
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
<style>
.py-12 {
  margin-top: calc(60px + 1rem); 
}
</style>
