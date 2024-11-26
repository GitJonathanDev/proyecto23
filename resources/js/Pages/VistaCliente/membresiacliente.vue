<template>
  <div>
    <plantillanavcliente :userName="$page.props.auth.user.name" />
    <div class="row justify-content-center mb-4">
      <div class="col-12 text-center">
        <h2 class="font-weight-bold" style="font-size: 2rem;">
          <em>¡Impulsa Tu Rutina con Tus Membresías Exclusivas aquí!</em>
        </h2>
      </div>
    </div>

    <div v-if="membresias.length === 0" class="row justify-content-center mb-4">
      <div class="col-12 text-center">
        <a class="navbar-brand" href="#">
          <span class="font-weight-bold">¡No tienes membresías aún!</span>
        </a>
        <p class="lead">Explora nuestras opciones para encontrar la membresía ideal para ti.</p>
      </div>
    </div>

    <div v-else>
      <div class="row justify-content-left mb-3 ">
        <div class="col-4 text-left">
          <select id="filter" class="form-control" v-model="selectedFilter" @change="filterMembresias">
            <option value="all">Todas</option>
            <option value="expired">Vencidas</option>
            <option value="active">Vigentes</option>
          </select>
        </div>
      </div>

      <!-- Contenedor de tarjetas de membresías -->
      <div class="memberships-container">
        <div 
          class="column" 
          v-for="(col, colIndex) in 3" 
          :key="colIndex">
          <div
            v-for="membresia in filteredMembresias.filter((_, index) => index % 3 === colIndex)"
            :key="membresia.id"
            class="membership-card-wrapper"
          >
            <div 
              class="card membership-card" 
              :class="{ 'expanded': membresia.showDetails }"
              @click="toggleDetails(membresia)">
              <div class="card-body">
                <div class="card-summary">
                  <h5 class="card-title">Membresía: {{ membresia.descripcion }}</h5>
                  <p class="card-text pb-4"><strong>Precio total:</strong> {{ membresia.precioTotal }} Bs.</p>
                </div>
                <div v-show="membresia.showDetails" class="card-details">
                  <div v-if="membresia.detalles.length > 0">
                    <div 
                      v-for="detalle in membresia.detalles" 
                      :key="detalle.id" 
                      class="service-details mb-4 p-3 border rounded">
                      <p><strong>Servicio:</strong> {{ detalle.servicio.nombre }}</p>
                      <p><strong>Descripción:</strong> {{ detalle.servicio.descripcion }}</p>
                      <p><strong>Tipo:</strong> {{ detalle.tipo }}</p>
                      <p><strong>Subtotal:</strong> {{ detalle.subTotal }} Bs.</p>
                      <p><strong>Fecha de inicio del servicio:</strong> {{ formatDate(detalle.fechaInicio) }}</p>
                      <p><strong>Fecha de fin del servicio:</strong> {{ formatDate(detalle.fechaFin) }}</p>

                      <p><strong>Horario:</strong> {{ detalle.servicio.horario.horaInicio }} - {{ detalle.servicio.horario.horaFin }}</p>
                      <p><strong>Estado:</strong>
                        <span :class="getEstadoClass(detalle.estado)">{{ detalle.estado }}</span>
                      </p>
                    </div>
                  </div>
                  <p v-else>No hay detalles disponibles para esta membresía.</p>
                </div>
                <!-- Overlay para membresías vencidas -->
                <div v-if="isMembresiaExpired(membresia)" class="overlay">
                  <div class="overlay-text">Vencida</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <VisitaFooter />
  </div>
</template>



<script>
import plantillanavcliente from '@/Layouts/plantillanavcliente.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';

export default {
  components: {
    plantillanavcliente,
    VisitaFooter, 
  },
  props: {
    membresias: Array, // Recibimos las membresías desde Inertia
  },
  data() {
    return {
      selectedFilter: "all",
    };
  },
  computed: {
    filteredMembresias() {
      return this.selectedFilter === "all"
        ? this.membresias
        : this.membresias.filter(membresia =>
            (this.selectedFilter === "expired" && this.isMembresiaExpired(membresia)) ||
            (this.selectedFilter === "active" && !this.isMembresiaExpired(membresia))
          );
    },
  },
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('es-ES'); // Formato: DD/MM/YYYY
    },
    isMembresiaExpired(membresia) {
      // Verificamos si todos los servicios de la membresía están vencidos
      return membresia.detalles.every(detalle => new Date(detalle.fechaFin) < new Date());
    },
    toggleDetails(membresia) {
      membresia.showDetails = !membresia.showDetails;
    },
    getEstadoClass(estado) {
      return {
        'badge-danger': estado === 'Vencida',
        'badge-warning': estado === 'Próximo a Expirar',
        'badge-success': estado === 'Activo'
      };
    },
  },
};
</script>



<style scoped>
.memberships-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* Tres columnas */
  gap: 16px; /* Espaciado entre columnas */
}

.column {
  display: flex;
  flex-direction: column; /* Apilado vertical */
  gap: 16px; /* Espaciado entre tarjetas dentro de cada columna */
}

.membership-card-wrapper {
  width: 100%; /* Ajusta al ancho de la columna */
}

.membership-card {
  position: relative;
  cursor: pointer;
  transition: box-shadow 0.3s ease, max-height 0.3s ease !important;
  width: 100%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

.membership-card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
}

.card-summary {
  margin-bottom: 0 !important;
}

.card-details {
  overflow: hidden !important;
  transition: max-height 0.3s ease-out !important;
  max-height: 0;
  padding-bottom: 16px;
}

.membership-card.expanded .card-details {
  max-height: 1000px; /* Ajuste flexible para mostrar todo el contenido */
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 0, 0, 0.5); /* Rojo con transparencia */
  color: white;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: bold;
  z-index: 10;
}

.overlay-text {
  font-size: 32px;
  font-weight: bold;
  color: white;
}
</style>
