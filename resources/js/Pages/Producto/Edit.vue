<script setup>
import { ref, computed } from 'vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Recibimos los datos de producto y categorías desde el controlador
const props = defineProps({
  producto: Object,
  categorias: Array,
  errors: Object,
});

// Inicializamos el formulario con los datos del producto
const form = useForm({
  nombre: props.producto?.nombre || '',
  descripcion: props.producto?.descripcion || '',
  precio: props.producto?.precio || '',
  codCategoriaF: props.producto?.codCategoriaF || '',
  imagen: null,
});

// Para manejar la previsualización de la imagen
const imagePreview = ref(null);

const handleImageChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  } else {
    imagePreview.value = null;
  }
};

// Validación en el cliente
const validateNombre = () => form.nombre.length > 2 && form.nombre.length < 101;
const validateDescripcion = () => form.descripcion.length > 4 && form.descripcion.length < 256;
const validatePrecio = () => parseFloat(form.precio) > 0;
const validateCategoria = () => form.codCategoriaF !== '';

// Validación del formulario
const isFormValid = computed(() => {
  return (
    validateNombre() && 
    validateDescripcion() && 
    validatePrecio() && 
    validateCategoria()
  );
});

// Función para manejar el envío del formulario
const submit = () => {
  const formData = new FormData();
  formData.append('nombre', form.nombre);
  formData.append('descripcion', form.descripcion);
  formData.append('precio', form.precio);
  formData.append('codCategoriaF', form.codCategoriaF);

  if (form.imagen) {
    formData.append('imagen', form.imagen);
  }

  form.put(route('producto.update', props.producto.codProducto), {
    data: formData,
    onSuccess: () => {
      // Redirect after success
      router.get(route('producto.index'));
    }
  });
};
</script>

<template>
  <plantillanav/>
  <AppLayout title="Modificar Producto">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Producto
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <!-- Alerta de éxito -->
            <div v-if="form.errors.success" class="alert alert-success">
              {{ form.errors.success }}
            </div>

            <!-- Errores de validación -->
            <div v-if="form.errors.nombre" class="alert alert-danger">
              {{ form.errors.nombre }}
            </div>
            <div v-if="form.errors.descripcion" class="alert alert-danger">
              {{ form.errors.descripcion }}
            </div>
            <div v-if="form.errors.precio" class="alert alert-danger">
              {{ form.errors.precio }}
            </div>
            <div v-if="form.errors.codCategoriaF" class="alert alert-danger">
              {{ form.errors.codCategoriaF }}
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit">
              <!-- Nombre -->
              <div class="mb-3 row">
                <InputLabel for="nombre" value="Nombre" />
                <InputError :message="form.errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  class="form-control"
                  placeholder="Ingrese el nombre del producto"
                  required
                />
              </div>

              <!-- Descripción -->
              <div class="mb-3 row">
                <InputLabel for="descripcion" value="Descripción" />
                <InputError :message="form.errors.descripcion" />
                <textarea
                  v-model="form.descripcion"
                  id="descripcion"
                  class="form-control"
                  placeholder="Ingrese la descripción del producto"
                  rows="3"
                  required
                ></textarea>
              </div>

              <!-- Precio -->
              <div class="mb-3 row">
                <InputLabel for="precio" value="Precio" />
                <InputError :message="form.errors.precio" />
                <TextInput
                  v-model="form.precio"
                  type="number"
                  id="precio"
                  class="form-control"
                  placeholder="Ingrese el precio del producto"
                  required
                />
              </div>

              <!-- Categoría -->
              <div class="mb-3 row">
                <InputLabel for="codCategoriaF" value="Categoría" />
                <InputError :message="form.errors.codCategoriaF" />
                <select
                  v-model="form.codCategoriaF"
                  id="codCategoriaF"
                  class="form-select"
                  required
                >
                  <option value="">Seleccione una categoría</option>
                  <option
                    v-for="categoria in props.categorias"
                    :key="categoria.codCategoria"
                    :value="categoria.codCategoria"
                  >
                    {{ categoria.nombre }}
                  </option>
                </select>
              </div>

              <!-- Imagen -->
              <div class="mb-3 row">
                <InputLabel for="imagen" value="Cambiar Imagen" />
                <input
                  type="file"
                  id="imagen"
                  class="form-control"
                  accept="image/*"
                  @change="handleImageChange"
                />
                <img
                  v-if="imagePreview"
                  :src="imagePreview"
                  alt="Vista previa de la imagen"
                  class="img-fluid mt-2"
                />
              </div>

              <!-- Imagen actual -->
              <div class="mb-3 row">
                <InputLabel value="Imagen Actual" />
                <div v-if="props.producto.imagen_url">
                  <img
                    :src="`/storage/uploads/${props.producto.imagen_url}`"
                    alt="Imagen del producto"
                    width="200"
                  />
                </div>
                <div v-else>No tiene imagen actual</div>
              </div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link href="{{ route('producto.index') }}" class="btn btn-secondary me-2">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
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
    </div>
  </AppLayout>
</template>
<style>
.py-12 {
  margin-top: calc(60px + 1rem); 
}
</style>
