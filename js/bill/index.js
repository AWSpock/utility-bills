var chart = document.getElementById("chart");
if (chart) {
  var config = {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: unitLabel,
          data: data1,
          borderWidth: 1,
          yAxisID: "y",
        },
        {
          label: "Price",
          data: data2,
          borderWidth: 1,
          yAxisID: "y1",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: false,
          title: {
            display: true,
            text: unitLabel,
          },
        },
        y1: {
          beginAtZero: false,
          position: "right",
          ticks: {
            callback: function (value, index, ticks) {
              return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
              }).format(value);
            },
          },
        },
        x: {
          title: {
            display: true,
            text: "Bills",
          },
        },
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              if (context.datasetIndex === 1) {
                var label = context.dataset.label || "";

                if (label) {
                  label += ": ";
                }
                if (context.parsed.y !== null) {
                  label += new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD",
                  }).format(context.parsed.y);
                }
                return label;
              }
            },
          },
        },
      },
    },
  };

  new Chart(chart, config);
}
