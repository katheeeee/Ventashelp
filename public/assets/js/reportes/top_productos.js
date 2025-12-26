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
    const url_excel = cfg.url_excel || "";

    let chart = null;

    function ejecutar() {
      const desde = $("#desde").val();
      const hasta = $("#hasta").val();

      $.getJSON(url_data, { desde, hasta }).done(function (rows) {
        // OJO: tu JSON trae "nombre" y "cantidad"
        const labels = (rows || []).map(x => x.nombre);
        const data = (rows || []).map(x => Number(x.cantidad || 0));

        const canvas = document.getElementById("grafica_top");
        if (!canvas) return;

        if (chart) chart.destroy();

        chart = new Chart(canvas, {
          type: "bar",
          data: {
            labels,
            datasets: [{
              label: "cantidad vendida",
              data
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

        $("#btn_excel").attr("href", url_excel + "?desde=" + encodeURIComponent(desde) + "&hasta=" + encodeURIComponent(hasta));
      }).fail(function (xhr) {
        console.error(xhr.status, xhr.responseText);
        alert("error cargando top productos");
      });
    }

    const hoy = new Date().toISOString().slice(0, 10);
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    $("#btn_filtrar").on("click", function (e) {
      e.preventDefault();
      ejecutar();
    });

    ejecutar();
  });
})();
