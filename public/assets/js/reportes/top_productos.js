(function () {
  "use strict";

  let chart = null;

  function setExcelLink(desde, hasta) {
    const base = (window.reportes_cfg && window.reportes_cfg.url_excel) || "";
    const url = base + `?desde=${encodeURIComponent(desde)}&hasta=${encodeURIComponent(hasta)}&limit=10`;
    const a = document.getElementById("btn_excel");
    if (a) a.href = url;
  }

  function cargar() {
    const desde = document.getElementById("desde").value;
    const hasta = document.getElementById("hasta").value;

    setExcelLink(desde, hasta);

    const url = (window.reportes_cfg && window.reportes_cfg.url_data) || "";
    fetch(url + `?desde=${encodeURIComponent(desde)}&hasta=${encodeURIComponent(hasta)}`)
      .then(r => r.json())
      .then(data => {
        const labels = data.map(i => i.nombre);
        const valores = data.map(i => Number(i.cantidad)); // ✅ string -> number

        const canvas = document.getElementById("grafica");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");
        if (chart) chart.destroy(); // ✅ evita “reinit”

        chart = new Chart(ctx, {
          type: "bar",
          data: {
            labels,
            datasets: [{
              label: "cantidad vendida",
              data: valores
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
          }
        });
      })
      .catch(err => {
        console.error(err);
        alert("error cargando top productos");
      });
  }

  document.getElementById("btn_filtrar").addEventListener("click", cargar);
  cargar();
})();
