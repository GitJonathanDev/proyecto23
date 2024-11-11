  <template>
    <plantillanav/>
      <div class="container">
        <h2 class="text-center my-4">EDITAR CLIENTE</h2>
        <form @submit.prevent="submitForm" class="needs-validation" novalidate>
          <div v-if="errors.length" class="alert alert-danger">
            <ul>
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>
    
          <div class="py-12">
            <label for="carnetIdentidad" class="col-md-3 col-form-label">Cédula de identidad:</label>
            <div class="col-md-9">
              <input
                v-model="formData.carnetIdentidad"
                type="text"
                id="carnetIdentidad"
                class="form-control"
                :class="{'is-invalid': errors.carnetIdentidad}"
                required
              />
              <div v-if="errors.carnetIdentidad" class="invalid-feedback">
                {{ errors.carnetIdentidad }}
              </div>
            </div>
          </div>
    
          <div class="row mb-3">
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
              <input
                v-model="formData.nombre"
                type="text"
                id="nombre"
                class="form-control"
                :class="{'is-invalid': errors.nombre}"
                required
              />
              <div v-if="errors.nombre" class="invalid-feedback">
                {{ errors.nombre }}
              </div>
            </div>
          </div>
    
          <div class="row mb-3">
            <label for="apellidoPaterno" class="col-md-3 col-form-label">Apellido Paterno:</label>
            <div class="col-md-9">
              <input
                v-model="formData.apellidoPaterno"
                type="text"
                id="apellidoPaterno"
                class="form-control"
                :class="{'is-invalid': errors.apellidoPaterno}"
                required
              />
              <div v-if="errors.apellidoPaterno" class="invalid-feedback">
                {{ errors.apellidoPaterno }}
              </div>
            </div>
          </div>
    
          <div class="row mb-3">
            <label for="apellidoMaterno" class="col-md-3 col-form-label">Apellido Materno:</label>
            <div class="col-md-9">
              <input
                v-model="formData.apellidoMaterno"
                type="text"
                id="apellidoMaterno"
                class="form-control"
                :class="{'is-invalid': errors.apellidoMaterno}"
                required
              />
              <div v-if="errors.apellidoMaterno" class="invalid-feedback">
                {{ errors.apellidoMaterno }}
              </div>
            </div>
          </div>
    
          <div class="row mb-3">
            <label for="sexo" class="col-md-3 col-form-label">Sexo:</label>
            <div class="col-md-9">
              <select
                v-model="formData.sexo"
                id="sexo"
                class="form-control"
                :class="{'is-invalid': errors.sexo}"
                required
              >
                <option value="" disabled>Selecciona el sexo</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
              </select>
              <div v-if="errors.sexo" class="invalid-feedback">
                {{ errors.sexo }}
              </div>
            </div>
          </div>
    
          <div class="row mb-3">
            <label for="telefono" class="col-md-3 col-form-label">Teléfono:</label>
            <div class="col-md-9">
              <input
                v-model="formData.telefono"
                type="tel"
                id="telefono"
                class="form-control"
                :class="{'is-invalid': errors.telefono}"
                required
              />
              <div v-if="errors.telefono" class="invalid-feedback">
                {{ errors.telefono }}
              </div>
            </div>
          </div>
    
          <div class="row mb-3">
            <label for="edad" class="col-md-3 col-form-label">Edad:</label>
            <div class="col-md-9">
              <input
                v-model="formData.edad"
                type="number"
                id="edad"
                class="form-control"
                :class="{'is-invalid': errors.edad}"
                required
              />
              <div v-if="errors.edad" class="invalid-feedback">
                {{ errors.edad }}
              </div>
            </div>
          </div>
    
          <div class="text-center mt-4">
            <inertia-link href="/clientes" class="btn btn-secondary me-2">
              <i class="fas fa-arrow-left"></i> Atrás
            </inertia-link>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-pencil-alt"></i> Modificar
            </button>
          </div>
        </form>
      </div>
    </template>
    <script setup>
    import plantillanav from '@/Layouts/plantillanav.vue';
    </script>
    <script>
    export default {
      props: {
        cliente: Object,
      },
      data() {
        return {
          formData: {
            carnetIdentidad: this.cliente.carnetIdentidad,
            nombre: this.cliente.nombre,
            apellidoPaterno: this.cliente.apellidoPaterno,
            apellidoMaterno: this.cliente.apellidoMaterno,
            sexo: this.cliente.sexo,
            telefono: this.cliente.telefono,
            edad: this.cliente.edad,
          },
          errors: {},
        };
      },
      methods: {
        async submitForm() {
          try {
            this.errors = {};
            await this.$inertia.put(`/cliente/${this.formData.carnetIdentidad}`, this.formData);
          } catch (err) {
            this.errors = err.response.data.errors;
          }
        },
      },
    };
    </script>
    <style>
  .py-12 {
    margin-top: calc(60px + 1rem); 
  }
  </style>
    