<?php

namespace App\Http\Controllers\Venta;

use App\Venta;
use App\Comprobante;
use App\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ventas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ventas.create');
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
                "fecha_factura" => "required|date",
                "comprobante" => "required",
                "cliente" => "required|numeric",
                "tipo_pago" => "required|numeric",
                "total" => 'required|numeric'
            ];

            $this->validate($request, $rules);

            return DB::transaction(function() use($request){

                $comprobante = $this->obtenerNumeroComprobante($request->comprobante);

                $venta = new Venta();
                $venta->no_factura = $comprobante['no_comprobante'];
                $venta->correlativo = $comprobante['correlativo'];
                $venta->cliente_id = $request->get('cliente');
                $venta->tipo_pago_id = $request->get('tipo_pago');
                $venta->comprobante_id = $request->get('comprobante');
                $venta->fecha_factura = $request->get('fecha_factura');
                $venta->monto = $request->get('total');
                $venta->usuario_id = Auth::user()->id;
                $venta->save();

                foreach($request->get('lista') as $key => $item){
                    $detalle = new DetalleVenta();
                    $detalle->producto_id = $item['producto']['id'];
                    $detalle->venta_id = $venta->id;
                    $detalle->cantidad = $item['cantidad'];
                    $detalle->precio_unitario = $item['precio'];
                    $detalle->save();
                }

                return response()->json(['data' => 'Venta registrada con éxito']);

            });

        } catch (\Exception $ex) {

             if ($ex instanceof QueryException) {
                $codigo = $ex->errorInfo[2];

                return response()->json(['error' => $codigo],423);
            }
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $ordenadores = array("v.id","v.no_factura","v.monto","c.nombres","tp.nombre");

            $columna = $request['order'][0]["column"];

            $criterio = $request['search']['value'];

            $ventas = DB::table('venta as v')
                    ->join('cliente as c','c.id','v.cliente_id')
                    ->join('tipo_pago as tp','v.tipo_pago_id','tp.id')
                    ->select('v.id','v.no_factura','v.monto',DB::raw("CONCAT_WS('',c.nombres,'',c.apellidos) as cliente"),'tp.nombre as tipo_pago',DB::raw("TO_CHAR(v.fecha_factura,'dd-mm-yyyy') as fecha"))
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

            $count = DB::table('venta as v')
                    ->join('cliente as c','c.id','v.cliente_id')
                    ->join('tipo_pago as tp','v.tipo_pago_id','tp.id')
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->count();

            $data = array(
                'draw' => $request->draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $ventas,
            );

            return response()->json($data, 200);

        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 423);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function obtenerNumeroComprobante($comprobanteId)
    {
        $respuesta = array();

        $registro = DB::table('venta')
                        ->select(DB::raw('MAX(correlativo) as correlativo'))
                        ->where('comprobante_id',$comprobanteId)
                        ->first();

        $ceros = Comprobante::select('serie','cantidad_numeros')
                                ->where('id',$comprobanteId)
                                ->first();

        if($ceros && $ceros->cantidad_numeros > 0)
        {
            if(!$registro->correlativo || !$registro > 0)
            {
                $respuesta['correlativo'] = 1;
                $respuesta['no_comprobante'] = $ceros->serie.'-'.$this->agregarCeros($respuesta['correlativo'],$ceros->cantidad_numeros);
            }
            else
            {
                $respuesta['correlativo'] = $registro->correlativo + 1;
                $respuesta['no_comprobante'] = $ceros->serie.'-'.$this->agregarCeros($respuesta['correlativo'],$ceros->cantidad_numeros);
            }
        }
        else
        {
            throw new \Exception("No hay comprobantes habilitados");
        }

        return $respuesta;
    }

    public function agregarCeros($correlativo, $ceros)
    {
        return str_pad($correlativo, $ceros, '0', STR_PAD_LEFT);
    }
}
