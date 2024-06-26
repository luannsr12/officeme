
var ctx = document.getElementById("chart-bars").getContext("2d");

window.chart_one = new Chart(ctx, {

  type: "bar",
  data: {
    labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
    datasets: [{
      label: "Comissões R$",
      tension: 0.4,
      borderWidth: 0,
      borderRadius: 4,
      borderSkipped: false,
      backgroundColor: "#fff",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      maxBarThickness: 6
    },],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      }
    },
    interaction: {
      intersect: false,
      mode: 'index',
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: false,
          drawOnChartArea: false,
          drawTicks: false,
        },
        ticks: {
          suggestedMin: 0,
          suggestedMax: 500,
          beginAtZero: true,
          padding: 15,
          font: {
            size: 14,
            family: "Open Sans",
            style: 'normal',
            lineHeight: 2
          },
          color: "#fff"
        }
      },
      x: {
        grid: {
          drawBorder: true,
          display: true,
          drawOnChartArea: false,
          drawTicks: true
        },
        ticks: {
          display: true,
          color: "#fff"
        },
      },
    },
  },
});

var ctx2 = document.getElementById("chart-line").getContext("2d");

var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

gradientStroke1.addColorStop(1, 'rgb(130,214,22,0.2)');
gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

gradientStroke2.addColorStop(1, 'rgba(214,22,22,0.2)');
gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

window.chart_two = new Chart(ctx2, {
  type: "line",
  data: {
    labels: ["Jan", "Fev", "Mar", "Abr", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
    datasets: [{
      label: "Comissões",
      tension: 0.4,
      borderWidth: 0,
      pointRadius: 0,
      borderColor: "#82d616",
      borderWidth: 3,
      backgroundColor: gradientStroke1,
      fill: true,
      data: [50, 40, 100, 220, 0, 0, 0, 0, 0, 0, 0, 0],
      maxBarThickness: 6

    },
    {
      label: "Resgates",
      tension: 0.4,
      borderWidth: 0,
      pointRadius: 0,
      borderColor: "#ea0606",
      borderWidth: 3,
      backgroundColor: gradientStroke2,
      fill: true,
      data: [10, 30, 60, 120, 0, 0, 0, 0, 0, 0, 0, 0],
      maxBarThickness: 6
    },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      }
    },
    interaction: {
      intersect: false,
      mode: 'index',
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5]
        },
        ticks: {
          display: true,
          padding: 10,
          color: '#b2b9bf',
          font: {
            size: 11,
            family: "Open Sans",
            style: 'normal',
            lineHeight: 2
          },
        }
      },
      x: {
        grid: {
          drawBorder: false,
          display: false,
          drawOnChartArea: false,
          drawTicks: false,
          borderDash: [5, 5]
        },
        ticks: {
          display: true,
          color: '#b2b9bf',
          padding: 20,
          font: {
            size: 11,
            family: "Open Sans",
            style: 'normal',
            lineHeight: 2
          },
        }
      },
    },
  },
});