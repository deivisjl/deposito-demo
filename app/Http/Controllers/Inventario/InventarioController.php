<?php

namespace App\Http\Controllers\Inventario;

use App\Producto;
use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("p.id","p.nombre","c.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $productos = DB::table('producto as p')
                ->join('categoria as c','p.categoria_id','=','c.id')
                ->select('p.id','p.nombre','c.nombre as categoria','p.stock', DB::raw('TRUNC((((p.precio_promedio * p.porcentaje_ganancia)/100)+ p.precio_promedio),2) as precio'))
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
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        //
    }

    public function detalle($id){

        $producto = Producto::findOrFail($id);

        return view('inventario.detalle',['producto' => $producto]);
    }

    public function detalleProducto(Request $request){
        $ordenadores = array("p.id","to.nombre");

        $columna = $request['order'][0]["column"];

        $registro = $request['buscar'][0]['registro'];

        $historial = DB::table('producto as p')
                    ->join('inventario as i','i.producto_id','p.id')
                    ->join('tipo_operacion as to','i.tipo_operacion_id','to.id')
                    ->select('i.id','to.nombre','i.precio','i.cantidad','i.precio_promedio',DB::raw("TO_CHAR(i.created_at,'dd-mm-yyyy') as fecha"))
                    ->where('p.id',$registro)
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

        $count = DB::table('producto as p')
                ->join('inventario as i','i.producto_id','p.id')
                ->join('tipo_operacion as to','i.tipo_operacion_id','to.id')
                ->where('p.id',$registro)
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $historial,
        );

        return response()->json($data, 200);
    }
}
