(function () {
  "use strict";

  // =========================================================
  // onReady: espera jQuery
  // =========================================================
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

    const BASE_URL      = (CFG.BASE_URL || "").replace(/\/+$/, "") + "/";
    const IGV_RATE      = CFG.IGV_RATE ?? 0.18;

    // URLs que inyectas desde la vista (vadd.php)
    const URL_CLIENTES  = CFG.URL_CLIENTES  || "";  // base_url('ventas/ajaxclientes')
    const URL_PRODUCTOS = CFG.URL_PRODUCTOS || "";  // base_url('ventas/ajaxproductos')
    const URL_COMP_DATA = CFG.URL_COMP_DATA || "";  // base_url('ventas/ajaxcomprobantedata')
    const IMG_DEFAULT   = CFG.IMG_DEFAULT   || "";

    // =========================================================
    // Helpers numéricos
    // =========================================================
    function n2(v) {
      let x = parseFloat(String(v ?? "0").replace(",", "."));
      if (isNaN(x)) x = 0;
      return Math.round(x * 100) / 100;
    }
    function fmt(v) { return n2(v).toFixed(2); }
    function numStock(v) {
      const x = Number(String(v ?? "0").replace(",", "."));
      return isNaN(x) ? 0 : x;
    }

    // =========================================================
    // DOM helpers (ids)
    // =========================================================
    const SEL = {
      form: "#formVenta",
      tablaDetalle: "#tablaDetalle",
      itemsHidden: "#items",

      // totales
      total: "#total",
      subtotal: "#subtotal",
      igv: "#igv",

      // cliente
      btnBuscarCliente: "#btnBuscarCliente",
      inputClienteNombre: "#cliente_nombre",
      inputIdCliente: "#idcliente",
      modalClientes: "#modalClientes",
      qCliente: "#qCliente",
      tablaClientes: "#tablaClientes",

      // producto
      btnBuscarProducto: "#btnBuscarProducto",
      productoBuscar: "#producto_buscar",
      modalProductos: "#modalProductos",
      dtProductos: "#dtProductos",

      // comprobante
      tipoComprobante: "#idtipo_comprobante",
      serie: "#serie",
      numero: "#num_documento",
    };

    // =========================================================
    // DETALLE: utilidades
    // =========================================================
    function getRowById(id) {
      return $(`${SEL.tablaDetalle} tbody tr[data-id="${id}"]`);
    }

    function buildItems() {
      const items = [];
      $(`${SEL.tablaDetalle} tbody tr`).each(function () {
        const $tr = $(this);
        items.push({
          idproducto: parseInt($tr.attr("data-id"), 10),
          precio: n2($tr.find(".precio").text()),
          cantidad: n2($tr.find(".cantidad").val()),
          importe: n2($tr.find(".importe").text()),
        });
      });
      $(SEL.itemsHidden).val(JSON.stringify(items));
    }

    function calc() {
      let total = 0;

      $(`${SEL.tablaDetalle} tbody tr`).each(function () {
        const $tr = $(this);
        const precio = n2($tr.find(".precio").text());
        const cant = n2($tr.find(".cantidad").val());
        const imp = n2(precio * cant);

        $tr.find(".importe").text(fmt(imp));
        total += imp;
      });

      const subtotal = total / (1 + IGV_RATE);
      const igv = total - subtotal;

      $(SEL.total).val(fmt(total));
      $(SEL.subtotal).val(fmt(subtotal));
      $(SEL.igv).val(fmt(igv));

      buildItems();
    }

    function enforceRowStock($tr) {
      const max = numStock($tr.attr("data-stock"));
      if (max <= 0) return;

      const $inp = $tr.find(".cantidad");
      let v = numStock($inp.val());

      if (!v || v <= 0) v = 1;
      if (v > max) v = max;

      // enteros
      v = Math.round(v);
      if (v < 1) v = 1;

      $inp.val(v);
    }

    function addProducto(p) {
      const id = parseInt(p.idproducto, 10);
      if (!id) return;

      const st = numStock(p.stock);

      if (st <= 0) {
        alert("Este producto no tiene stock.");
        return;
      }

      const $row = getRowById(id);
      if ($row.length) {
        let c = numStock($row.find(".cantidad").val());
        c = Math.round(c + 1);
        $row.find(".cantidad").val(c);
        enforceRowStock($row);
        calc();
        return;
      }

      const img = p.img_url ? p.img_url : IMG_DEFAULT;
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
          <td style="width:140px;">
            <input type="number" min="1" step="1" class="form-control cantidad" value="1" max="${stockNum}">
          </td>
          <td class="importe text-right">0.00</td>
          <td class="text-center" style="width:60px;">
            <button type="button" class="btn btn-danger btn-sm btnDel" title="Quitar">
              <i class="fa fa-times"></i>
            </button>
          </td>
        </tr>
      `);

      $tr.find(".codigo").text(p.codigo ?? "");
      $tr.find(".nombre").text(p.nombre ?? "");
      $tr.find(".um").text(p.unmedida ?? "");
      $tr.find(".precio").text(fmt(p.precio));

      if (stockNum <= 0) {
        $tr.find(".stock").html('<span class="badge badge-danger">SIN STOCK</span>');
      } else {
        $tr.find(".stock").text(stockNum);
      }

      $(`${SEL.tablaDetalle} tbody`).append($tr);
      enforceRowStock($tr);
      calc();
    }

    // =========================================================
    // CLIENTES: modal + búsqueda
    // =========================================================
    function cargarClientes(q) {
      if (!URL_CLIENTES) {
        console.error("❌ Falta CFG.URL_CLIENTES");
        return $.Deferred().reject().promise();
      }
      return $.getJSON(URL_CLIENTES, { q: q || "" });
    }

    function renderClientes(rows) {
      const $tb = $(`${SEL.tablaClientes} tbody`);
      $tb.empty();

      (rows || []).forEach((r) => {
        const $tr = $(`
          <tr data-id="${r.idcliente}" data-nombre="${(r.nombre ?? "").replace(/"/g, "&quot;")}">
            <td class="text-center">
              <button type="button" class="btn btn-success btn-sm selCli">Add</button>
            </td>
            <td>${r.codigo ?? ""}</td>
            <td>${r.nombre ?? ""}</td>
          </tr>
        `);
        $tb.append($tr);
      });

      // auto selección si solo hay 1
      if (rows && rows.length === 1) {
        $(SEL.inputIdCliente).val(rows[0].idcliente);
        $(SEL.inputClienteNombre).val(rows[0].nombre ?? "");
        $(SEL.modalClientes).modal("hide");
      }
    }

    let tCli = null;

    $(SEL.btnBuscarCliente).on("click", function () {
      $(SEL.modalClientes).modal("show");
      $(SEL.qCliente).val("");
      cargarClientes("").done(renderClientes);
      setTimeout(() => $(SEL.qCliente).focus(), 150);
    });

    $(SEL.qCliente).on("keyup", function () {
      clearTimeout(tCli);
      const q = $(this).val().trim();
      tCli = setTimeout(() => {
        cargarClientes(q).done(renderClientes);
      }, 200);
    });

    // input directo en campo cliente (si escribes y enter -> abre modal)
    let tCli2 = null;
    $(SEL.inputClienteNombre).on("keyup", function (e) {
      const q = $(this).val().trim();

      if (e.key === "Enter") {
        e.preventDefault();
        $(SEL.btnBuscarCliente).click();
        return;
      }

      clearTimeout(tCli2);
      tCli2 = setTimeout(function () {
        if (q.length >= 2) {
          $(SEL.modalClientes).modal("show");
          $(SEL.qCliente).val(q);
          cargarClientes(q).done(renderClientes);
          setTimeout(() => $(SEL.qCliente).focus(), 150);
        }
      }, 250);
    });

    // si editas nombre, invalidar id
    $(SEL.inputClienteNombre).on("input", function () {
      $(SEL.inputIdCliente).val("");
    });

    $(document).on("click", ".selCli", function () {
      const $tr = $(this).closest("tr");
      $(SEL.inputIdCliente).val($tr.attr("data-id"));
      $(SEL.inputClienteNombre).val($tr.attr("data-nombre"));
      $(SEL.modalClientes).modal("hide");
    });

    // =========================================================
    // PRODUCTOS: modal + DataTable (sin duplicados)
    // =========================================================
    let dtProd = null;

    function cargarProductos(q) {
      if (!URL_PRODUCTOS) {
        console.error("❌ Falta CFG.URL_PRODUCTOS");
        return $.Deferred().reject().promise();
      }
      return $.getJSON(URL_PRODUCTOS, { q: q || "" });
    }

    function initDtProductosConData(rows) {
      // Fallback si DataTables no está cargado
      if (!$.fn.DataTable) {
        const $tb = $(`${SEL.dtProductos} tbody`);
        $tb.empty();

        (rows || []).forEach((r) => {
          const st = numStock(r.stock);
          const img = r.img_url || IMG_DEFAULT;
          const disabled = st <= 0 ? "disabled" : "";

          $tb.append(`
            <tr>
              <td class="text-center">
                <button type="button" class="btn btn-success btn-sm selProdRaw" ${disabled} title="Agregar">
                  <i class="fa fa-check"></i>
                </button>
              </td>
              <td>${r.codigo ?? ""}</td>
              <td>${r.nombre ?? ""}</td>
              <td class="text-center">
                <img src="${img}" class="img-thumbnail" style="max-width:60px; max-height:60px;">
              </td>
              <td class="text-right">${fmt(r.precio)}</td>
              <td class="text-right">${st <= 0 ? '<span class="badge badge-danger">SIN STOCK</span>' : st}</td>
              <td>${r.unmedida ?? ""}</td>
            </tr>
          `);
        });

        // click en fallback
        $(`${SEL.dtProductos} tbody`)
          .off("click", ".selProdRaw")
          .on("click", ".selProdRaw", function () {
            const idx = $(this).closest("tr").index();
            const row = (rows || [])[idx];
            if (row) addProducto(row);
            $(SEL.modalProductos).modal("hide");
            $(SEL.productoBuscar).val("");
          });

        return;
      }

      // destruir limpio si ya existe
      if ($.fn.DataTable.isDataTable(SEL.dtProductos)) {
        $(SEL.dtProductos).DataTable().clear().destroy();
        $(`${SEL.dtProductos} tbody`).empty();
      }

      dtProd = $(SEL.dtProductos).DataTable({
        pageLength: 10,
        data: rows || [],
        columns: [
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
            }
          },
          { data: "codigo", defaultContent: "" },
          { data: "nombre", defaultContent: "" },
          {
            data: "img_url",
            orderable: false,
            searchable: false,
            className: "text-center",
            render: function (url) {
              const img = url || IMG_DEFAULT;
              return `<img src="${img}" class="img-thumbnail" style="max-width:60px; max-height:60px;">`;
            }
          },
          { data: "precio", className: "text-right", render: function (v) { return fmt(v); }, defaultContent: "0.00" },
          {
            data: "stock",
            className: "text-right",
            render: function (v) {
              const st = numStock(v);
              if (st <= 0) return `<span class="badge badge-danger">SIN STOCK</span>`;
              return st;
            },
            defaultContent: "0"
          },
          { data: "unmedida", defaultContent: "" }
        ],
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" }
      });

      // click agregar
      $(`${SEL.dtProductos} tbody`)
        .off("click", ".selProdDt")
        .on("click", ".selProdDt", function () {
          const row = dtProd.row($(this).closest("tr")).data();
          addProducto(row);
          $(SEL.modalProductos).modal("hide");
          $(SEL.productoBuscar).val("");
        });
    }

    $(SEL.btnBuscarProducto).on("click", function () {
      $(SEL.modalProductos).modal("show");
      setTimeout(function () {
        cargarProductos("").done(function (rows) {
          initDtProductosConData(rows);
        });
      }, 120);
    });

    // buscar en input producto_buscar (con debounce)
    let tProdKey = null;
    $(SEL.productoBuscar).on("keyup", function (e) {
      const q = $(this).val().trim();

      if (e.key === "Enter") {
        e.preventDefault();
        $(SEL.btnBuscarProducto).click();
        return;
      }

      clearTimeout(tProdKey);
      tProdKey = setTimeout(function () {
        $(SEL.modalProductos).modal("show");
        cargarProductos(q).done(function (rows) {
          initDtProductosConData(rows);
        });
      }, 250);
    });

    // =========================================================
    // AUTOLLENADO SERIE / NUMERO ✅ (FIX REAL)
    // =========================================================
    function fillSerieNumeroByTipo(id) {
      if (!id) {
        $(SEL.serie).val("");
        $(SEL.numero).val("");
        return;
      }

      if (!URL_COMP_DATA) {
        console.error("❌ Falta CFG.URL_COMP_DATA");
        return;
      }

      // URL_COMP_DATA debe ser: https://katverse.space/ventas/ajaxcomprobantedata
      const url = URL_COMP_DATA.replace(/\/+$/, "") + "/" + id;

      console.log("📌 Request comprobante:", url);

      $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        cache: false
      })
        .done(function (r) {
          console.log("✅ comprobante ok:", r);
          $(SEL.serie).val(r.serie || "");
          $(SEL.numero).val(r.numero || "");
        })
        .fail(function (xhr) {
          console.error("❌ comprobante fail:", xhr.status, xhr.responseText);
          $(SEL.serie).val("");
          $(SEL.numero).val("");
        });
    }

    $(SEL.tipoComprobante).on("change", function () {
      fillSerieNumeroByTipo($(this).val());
    });

    // autollena si ya viene seleccionado
    const initTipo = $(SEL.tipoComprobante).val();
    if (initTipo) fillSerieNumeroByTipo(initTipo);

    // =========================================================
    // DETALLE EVENTS
    // =========================================================
    $(document).on("input", `${SEL.tablaDetalle} .cantidad`, function () {
      const $tr = $(this).closest("tr");
      enforceRowStock($tr);
      calc();
    });

    $(document).on("click", `${SEL.tablaDetalle} .btnDel`, function () {
      $(this).closest("tr").remove();
      calc();
    });

    // =========================================================
    // SUBMIT
    // =========================================================
    $(SEL.form).on("submit", function (e) {
      if (!$(SEL.tipoComprobante).val()) {
        e.preventDefault();
        alert("Seleccione un comprobante.");
        return;
      }

      if (!$(SEL.serie).val() || !$(SEL.numero).val()) {
        e.preventDefault();
        alert("No se generó Serie/Número. Vuelve a elegir el comprobante.");
        return;
      }

      if (!$(SEL.inputIdCliente).val()) {
        e.preventDefault();
        alert("Seleccione un cliente (de la lista).");
        $(SEL.btnBuscarCliente).click();
        return;
      }

      if ($(`${SEL.tablaDetalle} tbody tr`).length === 0) {
        e.preventDefault();
        alert("Agregue al menos 1 producto.");
        return;
      }

      // validar stock
      let ok = true;
      $(`${SEL.tablaDetalle} tbody tr`).each(function () {
        const stock = numStock($(this).attr("data-stock"));
        const cant = numStock($(this).find(".cantidad").val());
        if (stock > 0 && cant > stock) ok = false;
        if (cant <= 0) ok = false;
      });

      if (!ok) {
        e.preventDefault();
        alert("Hay productos con cantidad inválida o mayor al stock.");
        return;
      }

      buildItems();
    });

    // Inicial
    calc();
  });
})();
