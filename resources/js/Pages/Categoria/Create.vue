<script setup>
import { ref, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

const props = defineProps({
    errors: Object,
});

const form = useForm({
    nombre: '', 
});

const submitButton = ref(null);

const validateNombre = () => {
    const nombre = form.nombre.trim();
    return nombre.length > 3 && nombre.length < 51; // Debe tener entre 4 y 50 caracteres
};
const validateForm = () => {
    submitButton.value.disabled = !validateNombre();
};
const submit = () => {
    form.post(route('categoria.store'), {
        onSuccess: () => {
            // Redirigimos al listado de categorías en caso de éxito
            router.get(route('categoria.index'));
        },
    });
};
watch(() => form.nombre, () => {
    validateForm();
});
</script>

<template>
    <plantillanav/>
    <AppLayout title="Registrar Categoría">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Categoría
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
<style>
.py-12 {
  margin-top: calc(60px + 1rem); 
}
</style>
