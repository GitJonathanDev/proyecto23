<template>
    <div class="welcome-container">
      <div class="welcome-message">
        <h1>¡Bienvenido, {{ clientName }}!</h1>
        <p>Estamos felices de tenerte con nosotros. Este es tu espacio personal.</p>
      </div>
  
      <div class="client-info">
        <h2>Detalles de tu perfil</h2>
        <ul>
          <li><strong>Nombre:</strong> {{ clientName }}</li>
          <li><strong>Correo electrónico:</strong> {{ clientEmail }}</li>
          <li><strong>Teléfono:</strong> {{ clientPhone }}</li>
          <li><strong>Edad:</strong> {{ clientAge }}</li>
          <li><strong>Sexo:</strong> {{ clientSex }}</li>
        </ul>
      </div>
  
    </div>
  </template>
  
  <script>
  export default {
    props: {
      // Las props que pasamos desde el controlador
      clientName: String,
      clientEmail: String,
      clientPhone: String,
      clientAge: Number,
      clientSex: String,
    },
  };
  </script>
  
  <style scoped>
  .welcome-container {
    text-align: center;
    margin: 50px;
  }
  
  .welcome-message {
    margin-bottom: 30px;
  }
  
  .client-info {
    margin-top: 30px;
  }
  
  .client-info ul {
    list-style-type: none;
    padding: 0;
  }
  
  .client-info li {
    margin: 10px 0;
  }
  
  .cta {
    margin-top: 30px;
  }
  
  .cta .btn {
    background-color: #3490dc;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
  }
  
  .cta .btn:hover {
    background-color: #2779bd;
  }
  </style>
  