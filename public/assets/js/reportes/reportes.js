$(function () {

  const base_url = window.location.origin + '/ventas/public/';

  function cargar_resumen(desde, hasta) {
    $.getJSON(base_url + 'reportes/resumen', { desde, hasta }, function (r) {
      $('#total_vendido').text(parseFloat(r.total_vendido || 0).toFixed(2));
      $('#total_ventas').text(r.total_ventas || 0);
      $('#total_igv').text(parseFloat(r.total_igv || 0).toFixed(2));
      $('#ticket_promedio').text(parseFloat(r.ticket_promedio || 0).toFixed(2));
    });
  }

  function cargar_ventas_diarias(desde, hasta) {
    $.getJSON(base_url + 'reportes/ventas_diarias', { desde, hasta }, function (rows) {

      const labels = rows.map(r => r.fecha);
      const data = rows.map(r => r.total);

      const ctx = document.getElementById('grafica_ventas').getContext('2d');

      if (window.chart_ventas) {
        window.chart_ventas.destroy();
      }

      window.chart_ventas = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'ventas por día',
            data: data,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.2)',
            fill: true
          }]
        }
      });
    });
  }

  $('#btn_filtrar').on('click', function () {
    const desde = $('#desde').val();
    const hasta = $('#hasta').val();

    cargar_resumen(desde, hasta);
    cargar_ventas_diarias(desde, hasta);
  });

});
