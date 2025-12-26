(function () {
  "use strict";

  let chart = null;

  function buildUrl(base, params) {
    const qs = new URLSearchParams(params).toString();
    return base + (base.includes('?') ? '&' : '?') + qs;
  }

  async function cargar() {
    const desde = document.getElementById('desde').value;
    const hasta = document.getElementById('hasta').value;

    const url = buildUrl(window.reportes_cfg.url_data, { desde, hasta });
    const res = await fetch(url);
    const json = await res.json();

    const ctx = document.getElementById('grafica_ventas');

    if (chart) chart.destroy();

    chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: json.labels || [],
        datasets: [{
          label: 'total',
          data: json.data || []
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn_filtrar').addEventListener('click', function () {
      cargar();
    });

    document.getElementById('btn_exportar').addEventListener('click', function (e) {
      e.preventDefault();
      const desde = document.getElementById('desde').value;
      const hasta = document.getElementById('hasta').value;

      if (!desde || !hasta) {
        alert('selecciona desde y hasta');
        return;
      }

      const url = buildUrl(window.reportes_cfg.url_export, { desde, hasta });
      window.location.href = url;
    });

    cargar();
  });
})();
