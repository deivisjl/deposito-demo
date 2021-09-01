<?php

namespace App\Http\Controllers\Compra;

use App\Compra;
use App\DetalleCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compras.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'lista' => 'required',
                "fecha_comprobante" => "required|date",
                "no_comprobante" => "required",
                "proveedor" => "required|numeric",
                "tipo_pago" => "required|numeric",
                "total" => 'required|numeric'
            ];

            $this->validate($request, $rules);

            return DB::transaction(function() use($request){

                $compra = new Compra();
                $compra->proveedor_id = $request->get('proveedor');
                $compra->tipo_pago_id = $request->get('tipo_pago');
                $compra->no_comprobante = $request->get('no_comprobante');
                $compra->fecha_comprobante = $request->get('fecha_comprobante');
                $compra->monto = $request->get('total');
                $compra->usuario_id = Auth::user()->id;
                $compra->save();

                foreach($request->get('lista') as $key => $item){
                    $detalle = new DetalleCompra();
                    $detalle->producto_id = $item['producto']['id'];
                    $detalle->compra_id = $compra->id;
                    $detalle->cantidad = $item['cantidad'];
                    $detalle->precio_unitario = $item['precio'];
                    $detalle->save();
                }

                return response()->json(['data' => 'Compra registrada con éxito']);

            });

        } catch (\Exception $ex) {

            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $ordenadores = array("c.id","c.monto","tp.nombre","p.nombre","c.created_at");

            $columna = $request['order'][0]["column"];

            $criterio = $request['search']['value'];


            $compras = DB::table('compra as c')
                    ->join('proveedor as p','c.proveedor_id','p.id')
                    ->join('tipo_pago as tp','c.tipo_pago_id','tp.id')
                    ->select('c.id','c.monto','p.nombre as proveedor','tp.nombre as tipo_pago',DB::raw("TO_CHAR(c.created_at,'dd-mm-yyyy') as fecha"))
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

            $count = DB::table('compra as c')
                    ->join('proveedor as p','c.proveedor_id','p.id')
                    ->join('tipo_pago as tp','c.tipo_pago_id','tp.id')
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->count();

            $data = array(
                'draw' => $request->draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $compras,
            );

            return response()->json($data, 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 423);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }
}
