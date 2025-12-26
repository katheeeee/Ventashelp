(function () {
  "use strict";

  let chart = null;
  function qs(id){ return document.getElementById(id); }

  function cargar() {
    const desde = qs("desde").value;
    const hasta = qs("hasta").value;

    qs("btn_excel").href = reportes_cfg.url_excel + "?desde=" + encodeURIComponent(desde) + "&hasta=" + encodeURIComponent(hasta);

    fetch(reportes_cfg.url_data + "?desde=" + encodeURIComponent(desde) + "&hasta=" + encodeURIComponent(hasta))
      .then(r => r.json())
      .then(json => {
        const ctx = qs("grafica").getContext("2d");
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: json.labels || [],
            datasets: [{
              label: "total vendido",
              data: json.data || []
            }]
          },
          options: { responsive:true, maintainAspectRatio:false }
        });
      })
      .catch(err => {
        console.error(err);
        alert("error cargando top productos");
      });
  }

  document.addEventListener("DOMContentLoaded", function () {
    qs("btn_filtrar").addEventListener("click", cargar);
    cargar();
  });
})();
