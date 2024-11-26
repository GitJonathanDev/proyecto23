<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

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

// Validaciones individuales
const validateNombre = () => form.nombre.length > 2 && form.nombre.length < 101;
const validateDescripcion = () => form.descripcion.length > 4 && form.descripcion.length < 256;
const validatePrecio = () => parseFloat(form.precio) > 0;
const validateCategoria = () => form.codCategoriaF !== '';

// Validar formulario completo
const validateForm = () => validateNombre() && validateDescripcion() && validatePrecio() && validateCategoria();
watch([() => form.nombre, () => form.descripcion, () => form.precio, () => form.codCategoriaF], validateForm);

// Enviar formulario
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
      router.get(route('producto.index'));
    },
  });
};
</script>

<template>
  <plantillanav :userName="$page.props.auth.user.name" />
  <AppLayout title="Editar Producto">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Producto
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg divgrande">
          <div class="p-6 lg:p-8 border-gray-200 divpequeno">
            <h1 class="text-2xl font-bold text-center mb-6">Editar Producto</h1>

            <!-- Validaciones de error -->
            <div v-if="form.errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in form.errors" :key="index">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="submit" novalidate>
              <!-- Nombre -->
              <div class="mb-4">
                <InputLabel for="nombre" value="Nombre" class="bb" />
                <InputError :message="form.errors.nombre" />
                <TextInput
                  v-model="form.nombre"
                  id="nombre"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el nombre del producto"
                  required
                  @input="validateForm"
                />
                <div v-if="!validateNombre()" class="text-red-500 text-sm dd">
                  * El nombre debe tener entre 3 y 100 caracteres.
                </div>
              </div>

              <!-- Descripción -->
              <div class="mb-4">
                <InputLabel for="descripcion" value="Descripción" class="bb" />
                <InputError :message="form.errors.descripcion" />
                <textarea
                  v-model="form.descripcion"
                  id="descripcion"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese la descripción del producto"
                  rows="3"
                  required
                ></textarea>
                <div v-if="!validateDescripcion()" class="text-red-500 text-sm dd">
                  * La descripción debe tener entre 5 y 255 caracteres.
                </div>
              </div>

              <!-- Precio -->
              <div class="mb-4">
                <InputLabel for="precio" value="Precio" class="bb" />
                <InputError :message="form.errors.precio" />
                <TextInput
                  v-model="form.precio"
                  type="number"
                  id="precio"
                  class="mt-1 block w-full cc"
                  placeholder="Ingrese el precio del producto"
                  required
                />
                <div v-if="!validatePrecio()" class="text-red-500 text-sm dd">
                  * El precio debe ser un número mayor a 0.
                </div>
              </div>

              <!-- Categoría -->
              <div class="mb-4">
                <InputLabel for="codCategoriaF" value="Categoría" class="bb" />
                <InputError :message="form.errors.codCategoriaF" />
                <select
                  v-model="form.codCategoriaF"
                  id="codCategoriaF"
                  class="mt-1 block w-full cc"
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
                <div v-if="!validateCategoria()" class="text-red-500 text-sm dd">
                  * Seleccione una categoría válida.
                </div>
              </div>

              <!-- Imagen -->
<div class="mb-4">
  <InputLabel for="imagen" value="Imagen" class="bb" />
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
<div class="mb-4">
  <InputLabel value="Imagen Actual" class="bb" />
  <div v-if="props.producto.imagen_url">
    <img
      :src="`/storage/uploads/${props.producto.imagen_url}`"
      alt="Imagen actual"
      width="200"
    />
  </div>
  <div v-else class="text-gray-500">No hay imagen actual.</div>
</div>

              <!-- Botones -->
              <div class="text-center mt-4">
                <Link :href="route('producto.index')" class="btn btn-secondary me-3">
                  <i class="fas fa-arrow-left"></i> Atrás
                </Link>
                <PrimaryButton
                  class="btn btn-primary"
                  :disabled="!validateForm() || form.processing"
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
