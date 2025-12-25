(function () {
  "use strict";

  const cfg = window.reportes_cfg || {};
  const base_url = (cfg.base_url || "").replace(/\/+$/, "") + "/";

  function fmt(n) {
    n = parseFloat(n || 0);
    return n.toFixed(2);
  }

  function cargar_resumen(desde, hasta) {
    return $.getJSON(base_url + "reportes/resumen", { desde, hasta });
  }

  function ejecutar() {
    const desde = $("#desde").val();
    const hasta = $("#hasta").val();

    cargar_resumen(desde, hasta).done(function (r) {
      $("#r_total_vendido").text(fmt(r.total_vendido));
      $("#r_total_ventas").text(r.total_ventas || 0);
      $("#r_total_igv").text(fmt(r.total_igv));
      $("#r_ticket_promedio").text(fmt(r.ticket_promedio));
    }).fail(function (xhr) {
      console.error("resumen error:", xhr.status, xhr.responseText);
      alert("error cargando resumen (mira consola)");
    });
  }

  $(function () {
    $("#btn_filtrar").on("click", ejecutar);

    // carga inicial: hoy
    const hoy = new Date().toISOString().slice(0, 10);
    $("#desde").val(hoy);
    $("#hasta").val(hoy);

    ejecutar();
  });
})();
