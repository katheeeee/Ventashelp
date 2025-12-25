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
      const data = (rows || []).map(r => parseFloat(r.total || 0));

      const ctx = document.getElementById("grafica_ventas");
      if (!ctx) return;

      if (chart) chart.destroy();

chart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: labels,
    datasets: [{
      label: "total vendido",
      data: data,
      backgroundColor: "rgba(54, 162, 235, 0.7)",
      borderColor: "rgba(54, 162, 235, 1)",
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function (value) {
            return "S/ " + value;
          }
        }
      }
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
