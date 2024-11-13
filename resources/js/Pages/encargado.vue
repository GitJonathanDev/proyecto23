<template>
    <div class="container">
      <h1 class="stats-header">Estadísticas del Gimnasio Body Fit</h1>
      <div class="stats-grid">
        <div class="stats-card total-members">
          <h5>Total de Miembros</h5>
          <p>{{ stats.totalMembers }}</p>
        </div>
        <div class="stats-card active-members">
          <h5>Miembros Activos</h5>
          <p>{{ stats.activeMembers }}</p>
        </div>
        <div class="stats-card total-sales">
          <h5>Cantidad de Ventas Realizadas</h5>
          <p>{{ stats.totalSales }}</p>
        </div>
        <div class="stats-card total-purchases">
          <h5>Cantidad de Compras Realizadas</h5>
          <p>{{ stats.totalPurchases }}</p>
        </div>
        <div class="stats-card monthly-sales">
          <h5>Ventas Mensuales</h5>
          <p>{{ stats.monthlySales }}</p>
        </div>
        <div class="stats-card monthly-purchases">
          <h5>Compras Mensuales</h5>
          <p>{{ stats.monthlyPurchases }}</p>
        </div>
      </div>
  
      <!-- Gráfico de Tortas -->
      <div class="stats-card top-selling-products">
        <h5 class="chart-title">Productos Más Vendidos</h5>
        <canvas id="topSellingProductsChart"></canvas>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent, onMounted } from 'vue';
  import { Chart } from 'chart.js';
  
  export default defineComponent({
    props: {
      stats: Object, // Recibe las estadísticas desde Inertia
    },
  
    methods: {
      // Método para renderizar el gráfico de torta
      renderTopSellingProductsChart() {
        const data = {
          labels: this.stats.topSellingProducts.map(product => `Producto ${product.producto_id}`), // Modificar si necesitas mostrar nombres
          datasets: [{
            data: this.stats.topSellingProducts.map(product => product.count),
            backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#57FF33', '#FF33A1'], // Colores de las secciones
            borderColor: '#ffffff',
            borderWidth: 2,
          }]
        };
  
        const ctx = document.getElementById('topSellingProductsChart').getContext('2d');
        new Chart(ctx, {
          type: 'pie', // Tipo de gráfico
          data: data,
          options: {
            responsive: true,
            animation: {
              animateRotate: true,
              animateScale: true,
            },
            plugins: {
              legend: {
                position: 'top',
                labels: {
                  font: {
                    size: 14,
                    weight: 'bold',
                    family: "'Roboto', sans-serif",
                  },
                  color: '#333',
                },
              },
              tooltip: {
                callbacks: {
                  label: function(tooltipItem) {
                    return `Ventas: ${tooltipItem.raw}`;
                  }
                }
              }
            }
          }
        });
      }
    },
  
    onMounted() {
      this.renderTopSellingProductsChart(); // Llamar al método cuando el componente se monta
    }
  });
  </script>
  
  <style scoped>
  /* Contenedor principal */
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px;
    background-color: #f4f7fc;
  }
  
  /* Título principal */
  .stats-header {
    text-align: center;
    margin-bottom: 40px;
    font-size: 2.5em;
    font-weight: bold;
    color: #4A5568;
  }
  
  /* Grid de tarjetas */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
  }
  
  /* Tarjetas individuales */
  .stats-card {
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease-in-out;
  }
  
  .stats-card:hover {
    transform: translateY(-8px);
  }
  
  .stats-card h5 {
    font-size: 1.3em;
    margin-bottom: 15px;
    font-weight: bold;
    color: #4A5568;
  }
  
  .stats-card p {
    font-size: 1.5em;
    color: #1A202C;
    font-weight: bold;
  }
  
  /* Colores específicos para cada tarjeta */
  .total-members {
    background-color: #4299e1;
    color: white;
  }
  
  .active-members {
    background-color: #48bb78;
    color: white;
  }
  
  .total-sales {
    background-color: #ed8936;
    color: white;
  }
  
  .total-purchases {
    background-color: #38b2ac;
    color: white;
  }
  
  .monthly-sales {
    background-color: #9f7aea;
    color: white;
  }
  
  .monthly-purchases {
    background-color: #e53e3e;
    color: white;
  }
  
  /* Estilo para el gráfico de tortas */
  .top-selling-products {
    margin-top: 40px;
    padding: 24px;
    background-color: #fff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    text-align: center;
    max-width: 800px;
    margin: 40px auto;
  }
  
  .chart-title {
    font-size: 1.8em;
    font-weight: bold;
    margin-bottom: 20px;
    color: #4A5568;
  }
  
  /* Estilo para el canvas */
  canvas {
    width: 100% !important;
    height: auto !important;
  }
  </style>
  