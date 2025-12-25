(function () {
  "use strict";

  function onReady(fn) {
    if (typeof window.jQuery === "undefined") {
      setTimeout(function () { onReady(fn); }, 50);
      return;
    }
    window.jQuery(fn);
  }

  onReady(function () {
    const $ = window.jQuery;
    const cfg = window.reportes_cfg || {};
    const url_data = cfg.url_data || "";

    console.log("✅ reportes js cargado");
    console.log("url_data =", url_data);

    let chart = null;

    function fecha_hoy() {
      return new Date().toISOString().slice(0, 10);
    }

    function cargar(desde, hasta) {
      return $.getJSON(url_data, { desde, hasta });
    }

function pintar(rows) {
  console.log("rows =", rows);

  const labels = (rows || []).map(r => r.fecha);
  const data = (rows || []).map(r => Number(r.total || 0));

  const canvas = document.getElementById("grafica_ventas");
  if (!canvas) return;

  // si no hay datos, no dibujes “vacío”
  if (!labels.length) {
    if (chart) chart.destroy();
    const ctx0 = canvas.getContext("2d");
    ctx0.clearRect(0, 0, canvas.width, canvas.height);
    ctx0.font = "16px Arial";
    ctx0.fillText("no hay ventas en ese rango", 20, 40);
    return;
  }

  if (chart) chart.destroy();

  const ctx = canvas.getContext("2d");

  chart = new Chart(ctx, {
    type: "bar",
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
          console.error("❌ ajax error:", xhr.status, xhr.responseText);
          alert("no carga datos (mira consola y network)");
        });
    }

    const hoy = fecha_hoy();
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    $("#btn_filtrar").on("click", ejecutar);
    ejecutar();
  });
})();
