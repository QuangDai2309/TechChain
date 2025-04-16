<template>
    <div class="card p-3 shadow-sm">
      <h5 class="mb-4">Biểu đồ doanh thu theo tháng</h5>
      <canvas ref="doanhThuChart"></canvas>
    </div>
  </template>
  
  <script>
  import { Chart, registerables } from 'chart.js';
  
  export default {
    name: 'ChartDoanhThu',
    mounted() {
      Chart.register(...registerables);
  
      const ctx = this.$refs.doanhThuChart.getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
          datasets: [
            {
              label: 'Doanh thu (triệu VND)',
              data: [120, 150, 180, 90, 200],
              backgroundColor: '#4CAF50'
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            },
            title: {
              display: true,
              text: 'Thống kê doanh thu'
            }
          }
        }
      });
    }
  };
  </script>
  
  <style scoped>
  canvas {
    max-width: 100%;
  }
  </style>
  