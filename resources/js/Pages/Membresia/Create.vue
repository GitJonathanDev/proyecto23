<script setup>
import { ref, reactive, watch, onMounted, nextTick } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import plantillanav from '@/Layouts/plantillanav.vue';

// Recibiendo propiedades desde Inertia
const props = defineProps({
    errors: Object,
    services: Array, // Servicios disponibles para la membresía
});

const form = useForm({
    descripcion: '', // Descripción de la membresía
    cliente: '', // Cliente seleccionado
    telefono: '', // Teléfono del cliente
    codClienteF: '', // Código del cliente
    serviciosSeleccionados: [], // Servicios seleccionados
    precioTotal: 0, // Total calculado
    fechaInicio: '', // Fecha de inicio
    fechaFin: '', // Fecha de fin
});

const resultadosClientes = ref([]); // Resultados de búsqueda de clientes
const serviciosSeleccionados = ref([]); // Lista de servicios seleccionados
const botonVenta = ref(null); // Referencia al botón de venta

// Función para verificar el estado del botón de "realizar venta"
const verificarEstadoBoton = () => {
    const clienteSeleccionado = form.codClienteF.trim() !== ''; // Verifica que el cliente esté seleccionado
    const descripcionValida = form.descripcion.trim().length > 2 && form.descripcion.trim().length < 21;
    const hayServiciosSeleccionados = serviciosSeleccionados.value.length > 0;

    // Solo habilitar el botón si se cumplen todas las condiciones
    nextTick(() => {
        if (botonVenta.value) {
            botonVenta.value.disabled = !(clienteSeleccionado && descripcionValida && hayServiciosSeleccionados);
        }
    });
};

// Verifica el estado inicial del botón de manera segura
onMounted(() => {
    nextTick(() => {
        if (botonVenta.value) {
            verificarEstadoBoton();
        }
    });
});

// Función para buscar clientes
const buscarCliente = () => {
    const query = form.cliente.trim();
    if (query.length > 2) {
        fetch(`/membresia/buscar?query=${query}`)
            .then(response => response.json())
            .then(data => {
                resultadosClientes.value = data;
            });
    } else {
        resultadosClientes.value = [];
    }
};

// Selección de cliente desde los resultados
const seleccionarCliente = (cliente) => {
    form.cliente = `${cliente.nombre} ${cliente.apellidoPaterno}`;
    form.telefono = cliente.telefono;
    form.codClienteF = cliente.carnetIdentidad;

    resultadosClientes.value = [];
    verificarEstadoBoton();
};

// Función para seleccionar servicio
const seleccionarServicio = (servicio) => {
    const tipoPrecio = servicio.tipoPrecio;
    const precio = parseFloat(servicio.precio);

    const servicioSeleccionado = {
        id: servicio.id,
        nombre: servicio.nombre,
        descripcion: servicio.descripcion,
        tipoPrecio,
        precio,
        cantidad: 1,
        fechaInicio: form.fechaInicio,
        fechaFin: calcularFechaFin(form.fechaInicio, tipoPrecio, 1),
    };

    serviciosSeleccionados.value.push(servicioSeleccionado);
    form.precioTotal += precio;

    verificarEstadoBoton();
};

// Calcular la fecha de fin basada en el tipo de servicio
const calcularFechaFin = (fechaInicio, tipo, cantidad) => {
    const fecha = new Date(fechaInicio);
    if (tipo === 'Diario') {
        fecha.setDate(fecha.getDate() + cantidad);
    } else if (tipo === 'Mensual') {
        fecha.setMonth(fecha.getMonth() + cantidad);
    } else if (tipo === 'Anual') {
        fecha.setFullYear(fecha.getFullYear() + cantidad);
    }
    return fecha.toISOString().split('T')[0];
};

// Eliminar servicio seleccionado
const quitarServicio = (id) => {
    serviciosSeleccionados.value = serviciosSeleccionados.value.filter(servicio => servicio.id !== id);
    form.precioTotal -= serviciosSeleccionados.value.find(servicio => servicio.id === id)?.precio || 0;
    verificarEstadoBoton();
};

// Enviar el formulario
const submit = () => {
    form.post(route('membresia.store'), {
        onSuccess: () => {
            router.get(route('membresia.index'));
        },
    });
};
</script>

<template>
    <plantillanav/>
    <AppLayout title="Registrar Membresía">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar Membresía
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" novalidate>
                            <!-- Campo de Descripción -->
                            <div class="mb-4">
                                <InputLabel for="descripcion" value="Descripción" />
                                <InputError :message="errors.descripcion" />
                                <TextInput 
                                    v-model="form.descripcion"
                                    id="descripcion"
                                    class="mt-1 block w-full"
                                    placeholder="Ingrese una descripción de la membresía"
                                    required
                                    @input="verificarEstadoBoton"
                                />
                            </div>

                            <!-- Búsqueda de Cliente -->
                            <div class="mb-4">
                                <InputLabel for="cliente" value="Buscar Cliente" />
                                <TextInput 
                                    v-model="form.cliente"
                                    id="cliente"
                                    class="mt-1 block w-full"
                                    placeholder="Buscar cliente por nombre"
                                    @input="buscarCliente"
                                />
                                <ul class="list-group mt-2" v-if="resultadosClientes.length > 0">
                                    <li 
                                        v-for="cliente in resultadosClientes" 
                                        :key="cliente.carnetIdentidad"
                                        @click="seleccionarCliente(cliente)" 
                                        class="list-group-item">
                                        {{ cliente.nombre }} {{ cliente.apellidoPaterno }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Servicios Seleccionados -->
                            <div class="mb-4">
                                <InputLabel for="serviciosSeleccionados" value="Servicios Seleccionados" />
                                <div v-for="service in props.services" :key="service.id" class="service-item">
                                    <button 
                                        type="button" 
                                        @click="seleccionarServicio(service)"
                                        class="btn btn-primary"
                                    >
                                        Seleccionar {{ service.nombre }} - ${{ service.precio }}
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de Servicios Seleccionados -->
                            <div class="mb-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Servicio</th>
                                            <th>Descripción</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Fecha Fin</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="servicio in serviciosSeleccionados" :key="servicio.id">
                                            <td>{{ servicio.nombre }}</td>
                                            <td>{{ servicio.descripcion }}</td>
                                            <td>{{ servicio.precio }}</td>
                                            <td>1</td>
                                            <td>{{ servicio.fechaFin }}</td>
                                            <td>
                                                <button 
                                                    @click="quitarServicio(servicio.id)" 
                                                    class="btn btn-danger">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Precio Total -->
                            <div class="mb-4">
                                <InputLabel for="precioTotal" value="Precio Total" />
                                <TextInput
                                    id="precioTotal"
                                    class="mt-1 block w-full"
                                    :value="form.precioTotal"
                                    disabled
                                />
                            </div>

                            <!-- Fecha de Inicio -->
                            <div class="mb-4">
                                <InputLabel for="fechaInicio" value="Fecha de Inicio" />
                                <input
                                    v-model="form.fechaInicio"
                                    type="date"
                                    id="fechaInicio"
                                    class="mt-1 block w-full"
                                    required
                                />
                            </div>

                            <div class="text-center">
                                <!-- Botón de Enviar -->
                                <PrimaryButton 
                                    ref="botonVenta"
                                    class="mt-4"
                                    :disabled="!botonVenta.value || botonVenta.value.disabled"
                                >
                                    Guardar Membresía
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
