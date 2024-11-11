<template>
    <div class="relative min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0">
        <!-- Overlay oscuro sobre la imagen de fondo -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Contenedor del formulario sin fondo -->
        <div class="relative w-full sm:max-w-md mt-6 px-6 py-4 bg-white bg-opacity-70 shadow-md sm:rounded-lg overflow-y-auto">
            <slot /> 
        </div>
    </div>
</template>

<style scoped>
/* Fondo de pantalla */
.min-h-screen {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url('img/fondo.jpg'); /* Fondo de imagen */
    background-repeat: no-repeat; /* La imagen de fondo no se repite */
    background-size: cover; /* Asegura que la imagen cubra todo el fondo */
    background-position: center; 
    overflow: auto; /* Permite desplazamiento si es necesario */
}

/* Overlay oscuro sobre la imagen de fondo */
.relative {
    position: relative;
}

.absolute {
    position: absolute;
}

.bg-black {
    background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
}

.bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5); /* Opacidad 50% para el overlay */
}

/* Contenedor del formulario */
.w-full {
    width: 100%;
}

/* Contenedor sin fondo y con bordes redondeados */
.sm\:max-w-md {
    max-width: 400px;
}

.mt-6 {
    margin-top: 1.5rem;
}

.px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.bg-white {
    background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco con opacidad */
}

.shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.sm\:rounded-lg {
    border-radius: 0.5rem; /* Bordes redondeados */
}

/* Para que el formulario sea desplazable si hay muchos campos */
.overflow-y-auto {
    max-height: 90vh; /* Evita que se desborde más allá de la pantalla */
    overflow-y: auto; /* Permite desplazamiento vertical */
}

/* Transición para los inputs y select */
.input-field,
.select-field {
    margin-top: 0.5rem;
    padding: 0.75rem; /* Espaciado interno */
    border: 1px solid #d1d5db; /* Color de borde */
    border-radius: 0.375rem; /* Bordes redondeados */
    transition: border-color 0.3s; /* Transición suave para el borde */
    width: 100%; /* Aseguramos que el select ocupe todo el ancho disponible */
}

.input-field:focus,
.select-field:focus {
    border-color: #4f46e5; /* Color del borde al enfocar */
    outline: none; /* Sin borde de enfoque predeterminado */
}
</style>
