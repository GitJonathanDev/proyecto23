<template>
    <AppLayout title="Registrar Producto">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Registrar Producto
        </h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
              <form @submit.prevent="submitForm" novalidate>
                <!-- Código del Producto -->
                <div class="mb-4">
                  <InputLabel for="codProducto" value="Código del Producto" />
                  <InputError :message="errors.codProducto" />
                  <TextInput
                    v-model="form.codProducto"
                    id="codProducto"
                    class="mt-1 block w-full"
                    placeholder="Ingrese el código del producto"
                    required
                  />
                  <div v-if="!validateField('codProducto')" class="text-red-500 text-sm">
                    * El código del producto debe tener entre 2 y 20 caracteres.
                  </div>
                </div>
  
                <!-- Nombre del Producto -->
                <div class="mb-4">
                  <InputLabel for="nombre" value="Nombre" />
                  <InputError :message="errors.nombre" />
                  <TextInput
                    v-model="form.nombre"
                    id="nombre"
                    class="mt-1 block w-full"
                    placeholder="Ingrese el nombre del producto"
                    required
                  />
                  <div v-if="!validateField('nombre')" class="text-red-500 text-sm">
                    * El nombre debe tener entre 2 y 50 caracteres.
                  </div>
                </div>
  
                <!-- Descripción -->
                <div class="mb-4">
                  <InputLabel for="descripcion" value="Descripción" />
                  <InputError :message="errors.descripcion" />
                  <TextInput
                    v-model="form.descripcion"
                    id="descripcion"
                    class="mt-1 block w-full"
                    placeholder="Ingrese la descripción del producto"
                    required
                  />
                  <div v-if="!validateField('descripcion')" class="text-red-500 text-sm">
                    * La descripción debe tener entre 5 y 250 caracteres.
                  </div>
                </div>
  
                <!-- Precio -->
                <div class="mb-4">
                  <InputLabel for="precio" value="Precio" />
                  <InputError :message="errors.precio" />
                  <TextInput
                    v-model="form.precio"
                    type="number"
                    id="precio"
                    class="mt-1 block w-full"
                    placeholder="Ingrese el precio del producto"
                    required
                  />
                  <div v-if="!validateField('precio')" class="text-red-500 text-sm">
                    * El precio debe ser mayor a 0.
                  </div>
                </div>
  
                <!-- Categoría -->
                <div class="mb-4">
                  <InputLabel for="codCategoriaF" value="Categoría" />
                  <InputError :message="errors.codCategoriaF" />
                  <select
                    v-model="form.codCategoriaF"
                    id="codCategoriaF"
                    class="form-select mt-1 block w-full"
                    required
                  >
                    <option value="">Seleccione una categoría</option>
                    <option
                      v-for="categoria in categorias"
                      :key="categoria.codCategoria"
                      :value="categoria.codCategoria"
                    >
                      {{ categoria.nombre }}
                    </option>
                  </select>
                  <div v-if="!validateField('codCategoriaF')" class="text-red-500 text-sm">
                    * Debe seleccionar una categoría.
                  </div>
                </div>
  
                <!-- Imagen -->
                <div class="mb-4">
                  <InputLabel for="imagen" value="Imagen" />
                  <input
                    type="file"
                    id="imagen"
                    class="form-control mt-1"
                    accept="image/*"
                    @change="handleImageChange"
                  />
                  <img v-if="imagePreview" :src="imagePreview" alt="Imagen Previa" class="img-fluid mt-2" />
                  <div v-if="!validateField('imagen')" class="text-red-500 text-sm">
                    * La imagen es obligatoria.
                  </div>
                </div>
  
                <!-- Botones -->
                <div class="text-center">
                  <Link href="{{ route('producto.index') }}" class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Atrás
                  </Link>
                  <PrimaryButton
                    :disabled="!isFormValid || form.processing"
                    class="mt-4"
                    :class="{ 'opacity-25': form.processing }"
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
  
  <script setup>
  import { ref, computed, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import InputLabel from '@/Components/InputLabel.vue';
  import InputError from '@/Components/InputError.vue';
  import TextInput from '@/Components/TextInput.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import { router } from '@inertiajs/vue3';
  
  // Recibiendo propiedades desde Inertia
  const props = defineProps({
    categorias: Array,
    errors: Object,
  });
  
  const form = useForm({
    codProducto: '',
    nombre: '',
    descripcion: '',
    precio: '',
    codCategoriaF: '',
    imagen: null,
  });
  
  const imagePreview = ref(null);
  
  // Validación de los campos
  const validateField = (field) => {
  const value = form[field];

  if (field === 'precio') return parseFloat(value) > 0;
  if (field === 'codCategoriaF') return value && value !== '';  // Asegurarse de que no sea vacío o nulo
  if (field === 'imagen') return value !== null && value !== undefined; // Verifica que el valor no sea null o undefined

  const minLength = {
    codProducto: 2,
    nombre: 2,
    descripcion: 5,
  };
  const maxLength = {
    codProducto: 20,
    nombre: 50,
    descripcion: 250,
  };

  return typeof value === 'string' && value.length >= minLength[field] && value.length <= maxLength[field];
};

  // Formulario habilitado si todos los campos son válidos
  const isFormValid = computed(() => {
    return (
      validateField('codProducto') &&
      validateField('nombre') &&
      validateField('descripcion') &&
      validateField('precio') &&
      validateField('codCategoriaF') &&
      validateField('imagen')
    );
  });
  
  const handleImageChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.imagen = file; // Asigna el archivo seleccionado a form.imagen
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result; // Establecer la vista previa de la imagen
    };
    reader.readAsDataURL(file);
  } else {
    form.imagen = null; // Asegúrate de que form.imagen se establece en null si no se selecciona ninguna imagen
    imagePreview.value = null;
  }
};

  
  // Función para enviar el formulario
  const submitForm = () => {
    form.post(route('producto.store'), {
      onSuccess: () => {
        router.get(route('producto.index'));
      },
    });
  };
  
  // Validación en tiempo real
  watch(
    () => form.codProducto,
    () => {}
  );
  watch(
    () => form.nombre,
    () => {}
  );
  watch(
    () => form.descripcion,
    () => {}
  );
  watch(
    () => form.precio,
    () => {}
  );
  watch(
    () => form.codCategoriaF,
    () => {}
  );
  </script>
  