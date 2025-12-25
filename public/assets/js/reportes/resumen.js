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

    let donut = null;

    function fmtMoney(v) {
      const n = Number(v || 0);
      return "S/ " + n.toFixed(2);
    }

    function ejecutar() {
      const desde = $("#desde").val();
      const hasta = $("#hasta").val();

      $.getJSON(url_data, { desde, hasta }).done(function (r) {
        $("#k_ventas").text(r.kpis.ventas || 0);
        $("#k_total").text(fmtMoney(r.kpis.total));
        $("#k_clientes").text(r.kpis.clientes || 0);
        $("#k_productos").text(r.kpis.productos || 0);

        const labels = (r.por_comprobante || []).map(x => x.nombre);
        const data = (r.por_comprobante || []).map(x => Number(x.total || 0));

        const canvas = document.getElementById("donut_comprobante");
        if (!canvas) return;

        if (donut) donut.destroy();

        donut = new Chart(canvas, {
          type: "doughnut",
          data: {
            labels: labels,
            datasets: [{ data: data }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false
          }
        });
      }).fail(function (xhr) {
        console.error(xhr.status, xhr.responseText);
        alert("error cargando resumen");
      });
    }

    const hoy = new Date().toISOString().slice(0, 10);
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    $("#btn_filtrar").on("click", ejecutar);
    ejecutar();
  });
})();
