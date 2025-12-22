(function () {
  "use strict";

  function onReady(fn) {
    if (typeof window.jQuery === "undefined") {
      setTimeout(function () { onReady(fn); }, 50);
      return;
    }
    jQuery(fn);
  }

  onReady(function () {
    const $ = window.jQuery;
    const CFG = window.VENTA_CFG || {};
    const IGV_RATE = CFG.IGV_RATE ?? 0.18;

    const URL_CLIENTES = CFG.URL_CLIENTES || "";
    const URL_PRODUCTOS = CFG.URL_PRODUCTOS || "";
    const IMG_DEFAULT = CFG.IMG_DEFAULT || "";

    console.log("✅ vadd.js VERSION STOCK BADGE 22-12-2025");

    function n2(v) {
      let x = parseFloat(String(v ?? "0").replace(",", "."));
      if (isNaN(x)) x = 0;
      return Math.round(x * 100) / 100;
    }
    function fmt(v) { return n2(v).toFixed(2); }

    // stock robusto: acepta "0", "0.00", "0,00", null
    function numStock(v) {
      return Number(String(v ?? "0").replace(",", "."));
    }

    function getRowById(id) {
      return $('#tablaDetalle tbody tr[data-id="' + id + '"]');
    }

    function buildItems() {
      const items = [];
      $("#tablaDetalle tbody tr").each(function () {
        const $tr = $(this);
        items.push({
          idproducto: parseInt($tr.attr("data-id"), 10),
          precio: n2($tr.find(".precio").text()),
          cantidad: n2($tr.find(".cantidad").val()),
          importe: n2($tr.find(".importe").text()),
        });
      });
      $("#items").val(JSON.stringify(items));
    }

    // ✅ TOTAL incluye IGV (tu lógica actual)
    function calc() {
      let total = 0;

      $("#tablaDetalle tbody tr").each(function () {
        const $tr = $(this);
        const precio = n2($tr.find(".precio").text());
        const cant = n2($tr.find(".cantidad").val());
        const imp = n2(precio * cant);

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

    // ✅ No permitir cantidad > stock en una fila
    function enforceRowStock($tr) {
      const max = numStock($tr.attr("data-stock"));
      if (max <= 0) return;

      const $inp = $tr.find(".cantidad");
      let v = numStock($inp.val());
      if (isNaN(v) || v <= 0) v = 1;
      if (v > max) v = max;
      $inp.val(v);
    }

    // ✅ Agregar producto (guarda stock y limita input)
    function addProducto(p) {
      const id = parseInt(p.idproducto, 10);
      if (!id) return;

      const st = numStock(p.stock);

      // si no hay stock, no permitir agregar
      if (st <= 0) {
        alert("Este producto no tiene stock.");
        return;
      }

      const $row = getRowById(id);
      if ($row.length) {
        let c = numStock($row.find(".cantidad").val());
        $row.find(".cantidad").val(Math.max(1, Math.round(c + 1)));
        enforceRowStock($row);
        calc();
        return;
      }

      const img = p.img_url ? p.img_url : IMG_DEFAULT;
      const precio = fmt(p.precio);
      const stockNum = st;

      const $tr = $(`
        <tr data-id="${id}" data-stock="${stockNum}">
          <td class="codigo"></td>
          <td class="nombre"></td>
          <td class="text-center">
            <img src="${img}" class="img-thumbnail" style="max-width:60px; max-height:60px;">
          </td>
          <td class="um"></td>
          <td class="precio text-right"></td>
          <td class="stock text-right"></td>
          <td>
            <input type="number" min="1" step="1" class="form-control cantidad" value="1" max="${stockNum}">
          </td>
          <td class="importe text-right">0.00</td>
          <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm btnDel">
              <i class="fa fa-times"></i>
            </button>
          </td>
        </tr>
      `);

      $tr.find(".codigo").text(p.codigo ?? "");
      $tr.find(".nombre").text(p.nombre ?? "");
      $tr.find(".um").text(p.unmedida ?? "");
      $tr.find(".precio").text(precio);

      if (stockNum <= 0) {
        $tr.find(".stock").html('<span class="badge badge-danger">NO HAY STOCK</span>');
      } else {
        $tr.find(".stock").text(stockNum);
      }

      $("#tablaDetalle tbody").append($tr);
      enforceRowStock($tr);
      calc();
    }

    // ===================== CLIENTES =====================
    function cargarClientes(q) {
      return $.getJSON(URL_CLIENTES, { q: q || "" });
    }

    function renderClientes(rows) {
      const $tb = $("#tablaClientes tbody");
      $tb.empty();

      (rows || []).forEach((r) => {
        const $tr = $(`
          <tr data-id="${r.idcliente}" data-nombre="${r.nombre ?? ""}">
            <td class="text-center">
              <button type="button" class="btn btn-success btn-sm selCli">Add</button>
            </td>
            <td>${r.codigo ?? ""}</td>
            <td>${r.nombre ?? ""}</td>
          </tr>
        `);
        $tb.append($tr);
      });
    }

    let tCli = null;

    $("#btnBuscarCliente").on("click", function () {
      $("#modalClientes").modal("show");
      $("#qCliente").val("");
      cargarClientes("").done(renderClientes);
      setTimeout(() => $("#qCliente").focus(), 200);
    });

    $("#qCliente").on("keyup", function () {
      clearTimeout(tCli);
      const q = $(this).val().trim();
      tCli = setTimeout(() => { cargarClientes(q).done(renderClientes); }, 200);
    });

    // buscar cliente escribiendo
    let tCli2 = null;
    $("#cliente_nombre").on("keyup", function (e) {
      const q = $(this).val().trim();

      if (e.key === "Enter") {
        e.preventDefault();
        $("#btnBuscarCliente").click();
        return;
      }

      clearTimeout(tCli2);
      tCli2 = setTimeout(function () {
        if (q.length >= 2) {
          $("#modalClientes").modal("show");
          $("#qCliente").val(q);
          cargarClientes(q).done(renderClientes);
          setTimeout(() => $("#qCliente").focus(), 150);
        }
      }, 250);
    });

    $(document).on("click", ".selCli", function () {
      const $tr = $(this).closest("tr");
      $("#idcliente").val($tr.attr("data-id"));
      $("#cliente_nombre").val($tr.attr("data-nombre"));
      $("#modalClientes").modal("hide");
    });

    // ===================== PRODUCTOS (DATATABLE) =====================
    let dtProd = null;

    function initDtProductos() {
      if (dtProd) return;

      dtProd = $("#dtProductos").DataTable({
        pageLength: 10,
        ajax: {
          url: URL_PRODUCTOS,
          dataSrc: "",
          data: function (d) {
            return { q: (d.search && d.search.value) ? d.search.value : "" };
          },
        },
        columns: [
          // ✅ botón add deshabilitado si stock=0
          {
            data: null,
            orderable: false,
            searchable: false,
            className: "text-center",
            render: function (data, type, row) {
              const st = numStock(row.stock);

              if (st <= 0) {
                return `<button type="button" class="btn btn-secondary btn-sm" disabled title="No hay stock">
                          <i class="fa fa-ban"></i>
                        </button>`;
              }

              return `<button type="button" class="btn btn-success btn-sm selProdDt" title="Agregar">
                        <i class="fa fa-check"></i>
                      </button>`;
            },
          },

          { data: "codigo" },
          { data: "nombre" },

          {
            data: "img_url",
            orderable: false,
            searchable: false,
            className: "text-center",
            render: function (url) {
              const img = url || IMG_DEFAULT;
              return `<img src="${img}" class="img-thumbnail" style="max-width:60px; max-height:60px;">`;
            },
          },

          {
            data: "precio",
            className: "text-right",
            render: function (v) { return fmt(v); },
          },

          // ✅ badge NO HAY STOCK
          {
            data: "stock",
            className: "text-right",
            render: function (v) {
              const st = numStock(v);
              if (st <= 0) return `<span class="badge badge-danger">NO HAY STOCK</span>`;
              return st;
            }
          },

          { data: "unmedida" },
        ],
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" },
      });

      $("#dtProductos tbody").on("click", ".selProdDt", function () {
        const row = dtProd.row($(this).closest("tr")).data();
        addProducto(row);
        $("#modalProductos").modal("hide");
        $("#producto_buscar").val("");
      });
    }

    $("#btnBuscarProducto").on("click", function () {
      $("#modalProductos").modal("show");
      setTimeout(function () {
        initDtProductos();
        dtProd.ajax.reload(null, false);
      }, 200);
    });

 $("#producto_buscar").on("keyup", function (e) {
  const q = $(this).val().trim();

  // Enter abre directamente
  if (e.key === "Enter") {
    e.preventDefault();
    $("#btnBuscarProducto").click();
    return;
  }

  clearTimeout(tProdKey);
  tProdKey = setTimeout(function () {

    // Si hay texto, abre y filtra por nombre/código
    if (q.length >= 1) {
      $("#modalProductos").modal("show");
      setTimeout(function () {
        initDtProductos();
        dtProd.search(q).draw(); // 🔥 busca por nombre
      }, 150);
    }

    // Si borran todo, mostrar todos los productos
    if (q.length === 0 && dtProd) {
      dtProd.search("").draw();
    }

  }, 250);
});


    // ===================== DETALLE EVENTS =====================
    $(document).on("input", "#tablaDetalle .cantidad", function () {
      const $tr = $(this).closest("tr");
      enforceRowStock($tr);
      calc();
    });

    $(document).on("click", "#tablaDetalle .btnDel", function () {
      $(this).closest("tr").remove();
      calc();
    });

    // ===================== SUBMIT =====================
    $("#formVenta").on("submit", function (e) {
      if (!$("#idcliente").val()) {
        e.preventDefault();
        alert("Seleccione un cliente.");
        return;
      }
      if ($("#tablaDetalle tbody tr").length === 0) {
        e.preventDefault();
        alert("Agregue al menos 1 producto.");
        return;
      }

      // validar stock en front
      let ok = true;
      $("#tablaDetalle tbody tr").each(function () {
        const stock = numStock($(this).attr("data-stock"));
        const cant = numStock($(this).find(".cantidad").val());
        if (stock > 0 && cant > stock) ok = false;
      });

      if (!ok) {
        e.preventDefault();
        alert("Hay productos con cantidad mayor al stock. Corrige antes de guardar.");
        return;
      }

      buildItems();
    });

    calc();
  });
})();
