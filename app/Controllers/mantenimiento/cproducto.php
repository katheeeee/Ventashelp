<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mproducto;
use App\Models\mcategoria;
use App\Models\mmarca;
use App\Models\mcolor;
use App\Models\mtipo_material;
use App\Models\munmedida;

class cproducto extends BaseController
{
    protected $producto;

    public function __construct()
    {
        $this->producto = new mproducto();
    }

    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // listado con nombres (joins)
        $registros = $this->producto
            ->select('producto.*,
                      categoria.nombre AS categoria,
                      marca.nombre AS marca,
                      color.nombre AS color,
                      tipo_material.nombre AS tipo_material,
                      unmedida.nombre AS unmedida')
            ->join('categoria', 'categoria.idcategoria = producto.idcategoria')
            ->join('marca', 'marca.idmarca = producto.idmarca')
            ->join('color', 'color.idcolor = producto.idcolor')
            ->join('tipo_material', 'tipo_material.idtipo_material = producto.idtipo_material')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida')
            ->findAll();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'producto',
            'registros' => $registros,
        ];

        return view('admin/producto/vlist', $data);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'active'         => 'mantenimiento',
            'subactive'      => 'producto',
            'categorias'     => (new mcategoria())->findAll(),
            'marcas'         => (new mmarca())->findAll(),
            'colores'        => (new mcolor())->findAll(),
            'tipos_material' => (new mtipo_material())->findAll(),
            'unmedidas'      => (new munmedida())->findAll(),
        ];

        return view('admin/producto/vadd', $data);
    }

    public function store()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'codigo'          => 'required|is_unique[producto.codigo]',
            'nombre'          => 'required',
            'descripcion'     => 'required',
            'precio'          => 'required|decimal',
            'stock'           => 'required|integer',
            'idcolor'         => 'required|integer',
            'idcategoria'     => 'required|integer',
            'idtipo_material' => 'required|integer',
            'idmarca'         => 'required|integer',
            'idunmedida'      => 'required|integer',
        ];

        $messages = [
            'codigo' => [
                'required'  => 'El código es obligatorio',
                'is_unique' => 'El código ya existe, intente con otro',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->producto->insert([
            'codigo'          => $this->request->getPost('codigo'),
            'nombre'          => $this->request->getPost('nombre'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'observacion'     => $this->request->getPost('observacion'),
            'imagen'          => $img ? $img->getRandomName() : '',
            'precio'          => $this->request->getPost('precio'),
            'stock'           => $this->request->getPost('stock'),
            'idcolor'         => $this->request->getPost('idcolor'),
            'idcategoria'     => $this->request->getPost('idcategoria'),
            'idtipo_material' => $this->request->getPost('idtipo_material'),
            'idmarca'         => $this->request->getPost('idmarca'),
            'idunmedida'      => $this->request->getPost('idunmedida'),
            'estado'          => 1,
        ]);

        return redirect()->to(base_url('mantenimiento/producto'))
            ->with('success', 'Producto guardado con éxito');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'active'         => 'mantenimiento',
            'subactive'      => 'producto',
            'p'              => $this->producto->find($id),
            'categorias'     => (new mcategoria())->findAll(),
            'marcas'         => (new mmarca())->findAll(),
            'colores'        => (new mcolor())->findAll(),
            'tipos_material' => (new mtipo_material())->findAll(),
            'unmedidas'      => (new munmedida())->findAll(),
        ];

        return view('admin/producto/vedit', $data);
    }

    public function update($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'codigo'          => "required|is_unique[producto.codigo,idproducto,$id]",
            'nombre'          => 'required',
            'descripcion'     => 'required',
            'precio'          => 'required|decimal',
            'stock'           => 'required|integer',
            'idcolor'         => 'required|integer',
            'idcategoria'     => 'required|integer',
            'idtipo_material' => 'required|integer',
            'idmarca'         => 'required|integer',
            'idunmedida'      => 'required|integer',
            'estado'          => 'required|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->producto->update($id, [
            'codigo'          => $this->request->getPost('codigo'),
            'nombre'          => $this->request->getPost('nombre'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'observacion'     => $this->request->getPost('observacion'),
            'imagen'          => $this->request->getPost('imagen') ?? '',
            'precio'          => $this->request->getPost('precio'),
            'stock'           => $this->request->getPost('stock'),
            'idcolor'         => $this->request->getPost('idcolor'),
            'idcategoria'     => $this->request->getPost('idcategoria'),
            'idtipo_material' => $this->request->getPost('idtipo_material'),
            'idmarca'         => $this->request->getPost('idmarca'),
            'idunmedida'      => $this->request->getPost('idunmedida'),
            'estado'          => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/producto'))
            ->with('success', 'Producto actualizado con éxito');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $producto = $this->producto
            ->select('producto.*,
                      categoria.nombre AS categoria,
                      marca.nombre AS marca,
                      color.nombre AS color,
                      tipo_material.nombre AS tipo_material,
                      unmedida.nombre AS unmedida')
            ->join('categoria', 'categoria.idcategoria = producto.idcategoria')
            ->join('marca', 'marca.idmarca = producto.idmarca')
            ->join('color', 'color.idcolor = producto.idcolor')
            ->join('tipo_material', 'tipo_material.idtipo_material = producto.idtipo_material')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida')
            ->find($id);

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'producto',
            'p'         => $producto,
        ];

        return view('admin/producto/vview', $data);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $this->producto->delete($id);

        return redirect()->to(base_url('mantenimiento/producto'))
            ->with('success', 'Producto eliminado');
    }
}
