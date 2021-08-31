<?php

namespace App\Http\Controllers\Administrar;

use App\Producto;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();

        return view('administrar.productos.create',['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string',
            "categoria" => "required|numeric",
            "maximo" => "required|numeric|min:0",
            "minimo" => "required|numeric|min:0",
            "descripcion" => 'nullable',
            "porcentaje_ganancia" => 'required|numeric|min:1|max:100'
        ];

        $this->validate($request, $rules);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria;
        $producto->stock_maximo = $request->maximo;
        $producto->stock_minimo = $request->minimo;
        $producto->descripcion = $request->descripcion;
        $producto->porcentaje_ganancia = $request->porcentaje_ganancia;
        $producto->save();

        return redirect('/productos')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("p.id","p.nombre","c.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $productos = DB::table('producto as p')
                ->join('categoria as c','p.categoria_id','=','c.id')
                ->select('p.id','p.nombre','c.nombre as categoria')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('producto as p')
                ->join('categoria as c','p.categoria_id','=','c.id')
                ->select('p.id','p.nombre','c.nombre as categoria')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $productos,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();

        return view('administrar.productos.edit',['categorias' => $categorias, 'producto' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $rules = [
            'nombre' => 'required|string',
            "categoria" => "required|numeric",
            "maximo" => "required|numeric|min:0",
            "minimo" => "required|numeric|min:0",
            "porcentaje_ganancia" => 'required|numeric|min:1|max:100',
            "descripcion" => 'nullable'
        ];

        $this->validate($request, $rules);

        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria;
        $producto->stock_maximo = $request->maximo;
        $producto->stock_minimo = $request->minimo;
        $producto->descripcion = $request->descripcion;
        $producto->porcentaje_ganancia = $request->porcentaje_ganancia;
        $producto->save();

        return redirect('/productos')->with(['mensaje' => 'Actualización exitosa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();

            return response()->json(['data' => 'Registro eliminado con éxito'],200);

        } catch (\Exception $e) {

            if ($e instanceof QueryException) {
                $codigo = $e->errorInfo[0];

                if ($codigo == 23503) {
                    return response()->json(['error' => 'No se puede eliminar porque tiene registros asociados'],423);
                }
            }
            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    public function buscarProductoNombre($criterio){

        $productos = DB::table('producto')
                        ->select('id','nombre','precio_promedio as precio')
                        ->where('nombre','LIKE','%'.$criterio.'%')
                        ->get();

        return response()->json(['data' => $productos,'code' => 200]);
    }
}
