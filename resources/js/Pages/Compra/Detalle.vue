<template>
    <AppLayout title="Detalle de la Compra">
      <template #header>
        <h1 class="text-2xl font-semibold text-gray-800">Detalle de Compra</h1>
      </template>
  
      <div class="container mx-auto px-4 py-6">
        <!-- Fecha de la compra -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Compra realizada el: {{ formatDate(compra.fechaCompra) }}</h2>
  
        <div v-if="detalleCompra && detalleCompra.length > 0" class="mt-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Productos Comprados</h3>
          <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Imagen</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Nombre</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Cantidad</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Precio Unitario</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="detalle in detalleCompra" :key="detalle.id" class="border-t">
                <td class="py-3 px-4">
                  <!-- Verificar que detalle.producto esté definido antes de acceder a sus propiedades -->
                  <img
                    v-if="safeGetProducto(detalle).imagen_url"
                    :src="`/storage/uploads/${safeGetProducto(detalle).imagen_url}`"
                    alt="Imagen del producto"
                    class="img-thumbnail w-24 h-24 object-cover rounded-lg"
                  />
                  <span v-else class="text-gray-500">No tiene imagen</span>
                </td>
                <td class="py-3 px-4 text-sm text-gray-700">{{ safeGetProducto(detalle).nombre }}</td>
                <td class="py-3 px-4 text-sm text-gray-700">{{ detalle.cantidad }}</td>
                <td class="py-3 px-4 text-sm text-gray-700">{{ formatCurrency(detalle.precioC) }} Bs.</td>
                <td class="py-3 px-4 text-sm text-gray-700">{{ formatCurrency(detalle.cantidad * detalle.precioC) }} Bs.</td>
              </tr>
              <tr v-if="detalleCompra.length === 0">
                <td colspan="5" class="text-center py-4 text-gray-500">No se han encontrado detalles de compra.</td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <!-- Total de la compra -->
        <div class="mt-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Total de la Compra</h3>
          <p class="text-xl font-semibold text-green-600">{{ formatCurrency(compra.montoTotal) }} Bs.</p>
        </div>
  
        <!-- Botón de Volver -->
        <div class="mt-6">
          <Link :href="route('compra.index')" class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
            Volver a la lista de compras
          </Link>
        </div>
      </div>
    </AppLayout>
  </template>
<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3'; // Inertia hook

// Obtener los datos desde Inertia
const { props } = usePage();
const compra = ref(props.compra || {});
const detalleCompra = ref(props.detalleCompra || []);

// Método para formatear fechas
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-BO', { day: '2-digit', month: '2-digit', year: 'numeric' });
};

// Método para formatear precios
const formatCurrency = (value) => {
  return new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(value);
};

// Función de seguridad para acceder a detalle.producto sin errores
const safeGetProducto = (detalle) => {
  // Si 'producto' no existe, devolvemos un objeto vacío con valores predeterminados
  return detalle.producto ? detalle.producto : { nombre: 'Producto no disponible', imagen_url: '' };
};
</script>
  