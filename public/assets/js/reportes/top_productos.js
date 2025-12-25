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

    let chart = null;

    function ejecutar() {
      const desde = $("#desde").val();
      const hasta = $("#hasta").val();

      $.getJSON(url_data, { desde, hasta }).done(function (rows) {
        const labels = (rows || []).map(r => r.nombre);
        const data = (rows || []).map(r => Number(r.total || 0));

        const canvas = document.getElementById("grafica_top");
        if (!canvas) return;

        if (chart) chart.destroy();

        chart = new Chart(canvas, {
          type: "bar",
          data: { labels, datasets: [{ label: "total vendido", data }] },
          options: {
            indexAxis: "y",
            responsive: true,
            maintainAspectRatio: false,
            scales: { x: { beginAtZero: true } }
          }
        });
      }).fail(function (xhr) {
        console.error(xhr.status, xhr.responseText);
        alert("error cargando top productos");
      });
    }

    const hoy = new Date().toISOString().slice(0, 10);
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    $("#btn_filtrar").on("click", ejecutar);
    ejecutar();
  });
})();
