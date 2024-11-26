<template>
  <div class="dashboard">
    <!-- Barra de navegación superior -->
    <plantillanav :userName="$page.props.auth.user.name" />

    <h1 class="ee">Bienvenido, Administrador</h1>
    <p class="ee">Estás en el panel de administración.</p>

    <!-- Módulos principales -->
    <div class="contenedor-modulos mt-8">
      <div
        v-for="modulo in modulos"
        :key="modulo.nombre"
        class="card bb"
        :class="{ activo: modulo.nombre === moduloActivo }"
        @mouseover="activarModulo(modulo.nombre)"
        @mouseleave="desactivarModulo(modulo.nombre)"
      >
        <figure>
          <img :src="modulo.imagen" :alt="'Imagen de ' + modulo.nombre" />
        </figure>
        <div class="cuerpo-card">
          <h2 class="titulo-card">{{ modulo.nombre }}</h2>
          <button class="btn btn-primary" @click="alternarModulo(modulo.nombre)">
            Ver opciones
          </button>
        </div>

        <!-- Opciones de gestionar -->
        <div v-if="modulo.nombre === moduloActivo" class="opciones-gestionar">
          <ul>
            <li v-for="(opcion, index) in modulo.opciones" :key="index">
              <a :href="opcion.ruta">{{ opcion.nombre }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <VisitaFooter />
  </div>
</template>

<script>
import plantillanav from '@/Layouts/plantillanav.vue';
import VisitaFooter from '@/Components/VisitaFooter.vue';
import axios from 'axios';

export default {
  name: 'Dashboard',
  components: {
    plantillanav,
    VisitaFooter,
  },
  data() {
    return {
      moduloActivo: null,
      modulos: [],
    };
  },
  methods: {
    alternarModulo(nombreModulo) {
      this.moduloActivo = this.moduloActivo === nombreModulo ? null : nombreModulo;
    },
    activarModulo(nombreModulo) {
      this.moduloActivo = nombreModulo;
    },
    desactivarModulo(nombreModulo) {
      if (this.moduloActivo === nombreModulo) {
        this.moduloActivo = null;
      }
    },
    async cargarOpcionesMenu() {
      try {
        const response = await axios.get('/menu-options'); 
        const imagenPredeterminada =
        'https://gestionsocios.com.uy/imagenes/noticias/c%C3%B3mo-ofrecer-un-gran-servicio-de-atenci%C3%B3n-al-cliente-a-los-socios-del-gimnasio-186-chica.jpg';

        this.modulos = Object.entries(response.data).map(([menuName, menuData]) => ({
          nombre: menuName,
          imagen: menuData.icono && menuData.icono.trim() !== '' ? menuData.icono : imagenPredeterminada,
          opciones: menuData.opciones,
        }));
      } catch (error) {
        console.error('Error al cargar las opciones del menú:', error);
      }
    },
  },
  created() {
    this.cargarOpcionesMenu();
  },
};
</script>

<style scoped>
.dashboard {
  padding: 20px;
  text-align: center;
}

.contenedor-modulos {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 10px;
}

.card {
  width: 22%;
  border-radius: 15px;
  overflow: hidden;
  transition: all 0.3s ease-in-out;
}

.card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.cuerpo-card {
  text-align: center;
  padding: 10px;
}

.titulo-card {
  font-size: 18px;
  margin-bottom: 10px;
}

.opciones-gestionar {
  margin-top: 10px;
  border-radius: 10px;
  width: 100%;
  box-sizing: border-box;
}

.opciones-gestionar ul {
  list-style: none;
  margin: 0;
  padding: 10px;
}

.opciones-gestionar li {
  margin-bottom: 5px;
}

.opciones-gestionar a {
  display: block;
  text-decoration: none;
  padding: 5px;
  border-radius: 4px;
  transition: background-color 0.3s, color 0.3s;
}

.card.activo {
  transform: translateY(-5px);
}

.ee {
  font-size: 20px;
  margin: 10px;
}
</style>
