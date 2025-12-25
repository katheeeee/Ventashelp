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

    console.log("✅ ventas_diarias.js cargado (bar)");
    console.log("url_data =", url_data);

    let chart = null;

    function ejecutar() {
      const desde = $("#desde").val();
      const hasta = $("#hasta").val();

      $.getJSON(url_data, { desde, hasta })
        .done(function (rows) {
          console.log("rows =", rows);

          const labels = (rows || []).map(r => r.fecha);
          const data = (rows || []).map(r => Number(r.total || 0));

          const canvas = document.getElementById("grafica_ventas");
          if (!canvas) return;

          if (chart) chart.destroy();

          chart = new Chart(canvas, {
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
        })
        .fail(function (xhr) {
          console.error("❌ ajax error:", xhr.status, xhr.responseText);
          alert("no carga datos (mira consola)");
        });
    }

    $("#btn_filtrar").on("click", ejecutar);

    // si tu input date es yyyy-mm-dd, esto está bien:
    const hoy = new Date().toISOString().slice(0, 10);
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    ejecutar();
  });
})();
