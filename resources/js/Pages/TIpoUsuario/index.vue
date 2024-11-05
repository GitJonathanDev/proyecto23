<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps(['tipoUsuario']); 
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Tipos de Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        Lista de Tipos de Usuarios
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="p-3">CodTipoUsuario</th> 
                                    <th class="p-3">Descripción</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Iteramos sobre tipoUsuario -->
                                <tr v-for="tipo in tipoUsuario" :key="tipo.id">
                                    <td class="p-3 border">{{ tipo.codtipousuario }}</td>
                                    <td class="p-3 border">{{ tipo.descripcion }}</td> 
                                    <td class="p-3 border">Acciones</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
