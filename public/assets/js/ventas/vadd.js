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
    const CFG = window.VENTA_CFG || {};

    const IGV_RATE = CFG.IGV_RATE ?? 0.18;
    const URL_CLIENTES = CFG.URL_CLIENTES || "";
    const URL_PRODUCTOS = CFG.URL_PRODUCTOS || "";
    const URL_COMP_DATA = CFG.URL_COMP_DATA || "";
    const IMG_DEFAULT = CFG.IMG_DEFAULT || "";

    // ================= UTILIDADES =================
    function n2(v) {
      let x = parseFloat(String(v ?? "0").replace(",", "."));
      return isNaN(x) ? 0 : Math.round(x * 100) / 100;
    }
    function fmt(v) { return n2(v).toFixed(2); }
    function num(v) { return Number(String(v ?? "0").replace(",", ".")); }

    // ================= DETALLE =================
    function getRowById(id) {
      return $('#tablaDetalle tbody tr[data-id="' + id + '"]');
    }

    function buildItems() {
      const items = [];
      $("#tablaDetalle tbody tr").each(function () {
        const $tr = $(this);
        items.push({
          idproducto: parseInt($tr.data("id")),
          precio: n2($tr.find(".precio").text()),
          cantidad: n2($tr.find(".cantidad").val()),
          importe: n2($tr.find(".importe").text())
        });
      });
      $("#items").val(JSON.stringify(items));
    }

    function calc() {
      let total = 0;

      $("#tablaDetalle tbody tr").each(function () {
        const $tr = $(this);
        const precio = n2($tr.find(".precio").text());
        const cant = n2($tr.find(".cantidad").val());
        const imp = precio * cant;

        $tr.find(".importe").text(fmt(imp));
        total += imp;
      });

      const subtotal = total / (1 + IGV_RATE);
      const igv = total - subtotal;

      $("#total").val(fmt(total));
      $("#subtotal").val(fmt(subtotal));
      $("#igv").val(fmt(igv));

      buildItems();
    }

    function enforceStock($tr) {
      const max = num($tr.data("stock"));
      let v = num($tr.find(".cantidad").val());
      if (v <= 0) v = 1;
      if (v > max) v = max;
      $tr.find(".cantidad").val(v);
    }

    function addProducto(p) {
      const id = parseInt(p.idproducto);
      if (!id) return;

      if (num(p.stock) <= 0) {
        alert("Producto sin stock");
        return;
      }

      const $row = getRowById(id);
      if ($row.length) {
        $row.find(".cantidad").val(num($row.find(".cantidad").val()) + 1);
        enforceStock($row);
        calc();
        return;
      }

      const $tr = $(`
        <tr data-id="${id}" data-stock="${p.stock}">
          <td>${p.codigo ?? ""}</td>
          <td>${p.nombre ?? ""}</td>
          <td class="text-center"><img src="${p.img_url || IMG_DEFAULT}" class="img-thumbnail" style="max-width:60px"></td>
          <td>${p.unmedida ?? ""}</td>
          <td class="precio text-right">${fmt(p.precio)}</td>
          <td class="text-right">${p.stock}</td>
          <td><input type="number" class="form-control cantidad" value="1" min="1"></td>
          <td class="importe text-right">0.00</td>
          <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm btnDel"><i class="fa fa-times"></i></button>
          </td>
        </tr>
      `);

      $("#tablaDetalle tbody").append($tr);
      calc();
    }

    // ================= CLIENTES =================
    function cargarClientes(q) {
      return $.getJSON(URL_CLIENTES, { q: q || "" });
    }

    $("#btnBuscarCliente").on("click", function () {
      $("#modalClientes").modal("show");
      cargarClientes("").done(renderClientes);
    });

    function renderClientes(rows) {
      const $tb = $("#tablaClientes tbody").empty();
      rows.forEach(r => {
        $tb.append(`
          <tr data-id="${r.idcliente}" data-nombre="${r.nombre}">
            <td><button class="btn btn-success btn-sm selCli">Add</button></td>
            <td>${r.codigo}</td>
            <td>${r.nombre}</td>
          </tr>
        `);
      });
    }

    $(document).on("click", ".selCli", function () {
      const $tr = $(this).closest("tr");
      $("#idcliente").val($tr.data("id"));
      $("#cliente_nombre").val($tr.data("nombre"));
      $("#modalClientes").modal("hide");
    });

    // ================= PRODUCTOS =================
    let dtProd = null;

    function initProductos(rows) {
      if ($.fn.DataTable.isDataTable("#dtProductos")) {
        $("#dtProductos").DataTable().clear().destroy();
      }

      dtProd = $("#dtProductos").DataTable({
        data: rows,
        pageLength: 10,
        columns: [
          {
            data: null,
            render: r => num(r.stock) > 0
              ? `<button class="btn btn-success btn-sm selProd"><i class="fa fa-check"></i></button>`
              : `<span class="badge badge-danger">SIN STOCK</span>`
          },
          { data: "codigo" },
          { data: "nombre" },
          { data: "precio", className: "text-right", render: v => fmt(v) },
          { data: "stock", className: "text-right" }
        ],
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" }
      });
    }

    $("#btnBuscarProducto").on("click", function () {
      $("#modalProductos").modal("show");
      $.getJSON(URL_PRODUCTOS).done(initProductos);
    });

    $(document).on("click", ".selProd", function () {
      const row = dtProd.row($(this).closest("tr")).data();
      addProducto(row);
      $("#modalProductos").modal("hide");
    });

    // ================= EVENTOS =================
    $(document).on("input", ".cantidad", function () {
      enforceStock($(this).closest("tr"));
      calc();
    });

    $(document).on("click", ".btnDel", function () {
      $(this).closest("tr").remove();
      calc();
    });

    $("#idtipo_comprobante").on("change", function () {
      const id = $(this).val();
      if (!id) return;

      $.getJSON(URL_COMP_DATA + "/" + id).done(r => {
        $("#serie").val(r.serie);
        $("#num_documento").val(r.numero);
      });
    });

    $("#formVenta").on("submit", function (e) {
      if ($("#tablaDetalle tbody tr").length === 0) {
        e.preventDefault();
        alert("Agrega productos");
      }
      buildItems();
    });

    calc();
  });
})();
