(function () {
  "use strict";

  const cfg = window.reportes_cfg || {};
  const base_url = (cfg.base_url || "").replace(/\/+$/, "") + "/";

  let chart = null;

  function cargar(desde, hasta) {
    return $.getJSON(base_url + "reportes/ventas_diarias", { desde, hasta });
  }

  function pintar(rows) {
    const labels = (rows || []).map(r => r.fecha);
    const data = (rows || []).map(r => parseFloat(r.total || 0));

    const ctx = document.getElementById("grafica_ventas");
    if (!ctx) return;

    if (chart) chart.destroy();

    chart = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "total vendido",
          data: data
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: "index", intersect: false },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }

  function ejecutar() {
    const desde = $("#desde").val();
    const hasta = $("#hasta").val();

    cargar(desde, hasta)
      .done(pintar)
      .fail(function (xhr) {
        console.error("ventas_diarias error:", xhr.status, xhr.responseText);
        alert("error cargando ventas diarias (mira consola)");
      });
  }

  function fecha_hoy() {
    return new Date().toISOString().slice(0, 10);
  }

  $(function () {
    const hoy = fecha_hoy();
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    $("#btn_filtrar").on("click", ejecutar);
    ejecutar();
  });
})();
