ready(loadData);

var data1 = [];
var data2 = [];
var labels = [];

async function loadData() {
  var table = document.getElementById("data-table");
  try {
    loader.show(true);

    var response = await fetch(
      "/api/address/" + address_id + "/bill-type/" + bill_type_id + "/bill",
      {
        method: "GET",
      }
    );
    // console.log(response);

    if (!response.ok) {
      throw new Error(`${response.statusText}`);
    }

    var data = await response.json();
    // console.log(data);

    loader.hide();

    var template = document.getElementById("template");
    // console.log(template);

    document.getElementById("data-table-count").textContent =
      data.length.toLocaleString("en-US");

    var x = 0;
    data.forEach(function (i) {
      var clone = template.content.cloneNode(true);

      var row = clone.querySelector(".data-table-row");
      var edit_link = row.getAttribute("href");
      row.setAttribute(
        "href",
        edit_link
          .replace("ADDRESS_ID", address_id)
          .replace("BILL_TYPE_ID", bill_type_id)
          .replace("BILL_ID", i.id)
      );

      clone.querySelector(
        '[data-id="bill-date"] .data-table-cell-content'
      ).textContent = i.bill_date;
      clone.querySelector(
        '[data-id="from-date"] .data-table-cell-content'
      ).textContent = i.from_date;
      clone.querySelector(
        '[data-id="to-date"] .data-table-cell-content'
      ).textContent = i.to_date;
      clone.querySelector(
        '[data-id="unit"] .data-table-cell-content'
      ).textContent = i.unit;
      clone.querySelector(
        '[data-id="price"] .data-table-cell-content'
      ).textContent = moneyFormat(i.price);
      clone.querySelector(
        '[data-id="created"] .data-table-cell-content'
      ).textContent = i.created;
      clone.querySelector(
        '[data-id="updated"] .data-table-cell-content'
      ).textContent = i.updated;

      table.appendChild(clone);

      if (x < 12) {
        data1.unshift(i.unit);
        data2.unshift(i.price);
        labels.unshift(i.to_date);
      }
      x++;
    });

    convertDateFields();

    loadChart();
  } catch (error) {
    console.error(error);
    table.innerHTML = "<div class='alert alert-danger'>" + error + "</div>";
  }
}

var chart = document.getElementById("chart");

function loadChart() {
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
}
