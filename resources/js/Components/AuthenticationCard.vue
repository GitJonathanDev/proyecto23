<template>
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0">
        <!-- Slot para logo, solo se renderiza una vez -->
        <div>
            <slot name="logo" />
        </div>

        <!-- Contenedor del formulario sin fondo -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white bg-opacity-70 shadow-md sm:rounded-lg overflow-y-auto">
            <slot /> 
        </div>
    </div>
</template>

<style scoped>
.min-h-screen {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.w-full {
    width: 100%;
}

/* Para que el formulario sea desplazable si hay muchos campos */
.overflow-y-auto {
    max-height: 90vh; /* Evita que se desborde más allá de la pantalla */
    overflow-y: auto; /* Permite desplazamiento vertical */
}

</style>
