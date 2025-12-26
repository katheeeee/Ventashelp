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

        // ✅ validar imagen SOLO si el usuario sube un archivo
        $img = $this->request->getFile('imagen');
        if ($img && $img->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['imagen'] = 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]';
            $messages['imagen'] = [
                'uploaded' => 'La imagen no se pudo subir',
                'max_size' => 'La imagen debe pesar máximo 2MB',
                'is_image' => 'El archivo debe ser una imagen',
            ];
        }

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // ✅ por defecto si NO sube imagen
        $nombreImagen = 'no.jpg';

        // ✅ si sube, mover y guardar nombre
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nombreImagen = $img->getRandomName();
            $img->move(FCPATH . 'uploads/productos', $nombreImagen);
        }

        $this->producto->insert([
            'codigo'          => $this->request->getPost('codigo'),
            'nombre'          => $this->request->getPost('nombre'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'observacion'     => $this->request->getPost('observacion'),
            'imagen'          => $nombreImagen, // ✅ siempre guarda algo (no.jpg o la subida)
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

        $img = $this->request->getFile('imagen');
        if ($img && $img->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['imagen'] = 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // ✅ mantener la imagen actual si NO sube otra
        $imagenActual = $this->request->getPost('imagen_actual') ?: 'no.jpg';
        $nombreImagen = $imagenActual;

        // ✅ si sube nueva, mover y guardar
        if ($img && $img->isValid() && !$img->hasMoved()) {

            $nombreImagen = $img->getRandomName();
            $img->move(FCPATH . 'uploads/productos', $nombreImagen);

            // ✅ borrar la vieja solo si NO es no.jpg
            if (!empty($imagenActual) && $imagenActual !== 'no.jpg') {
                $rutaVieja = FCPATH . 'uploads/productos/' . $imagenActual;
                if (is_file($rutaVieja)) {
                    @unlink($rutaVieja);
                }
            }
        }

        $this->producto->update($id, [
            'codigo'          => $this->request->getPost('codigo'),
            'nombre'          => $this->request->getPost('nombre'),
            'descripcion'     => $this->request->getPost('descripcion'),
            'observacion'     => $this->request->getPost('observacion'),
            'imagen'          => $nombreImagen,
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

        // ✅ borrar imagen física solo si no es no.jpg
        $p = $this->producto->find($id);
        if ($p && !empty($p['imagen']) && $p['imagen'] !== 'no.jpg') {
            $ruta = FCPATH . 'uploads/productos/' . $p['imagen'];
            if (is_file($ruta)) {
                @unlink($ruta);
            }
        }

        $this->producto->delete($id);

        return redirect()->to(base_url('mantenimiento/producto'))
            ->with('success', 'Producto eliminado');
    }
    public function ver_imagen($file)
{
    $path = FCPATH . 'uploads/productos/' . $file;

    if (!is_file($path)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $mime = mime_content_type($path) ?: 'image/jpeg';
    return $this->response
        ->setHeader('Content-Type', $mime)
        ->setBody(file_get_contents($path));
}

}
