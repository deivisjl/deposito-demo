<?php

namespace App\Http\Controllers\Administrar;

use App\TipoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class TipoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.tipo-pago.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.tipo-pago.create');
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
            'nombre' => 'required'
        ];

        $this->validate($request, $rules);

        $tipoPago = new TipoPago();
        $tipoPago->nombre = $request->nombre;
        $tipoPago->save();

        return redirect('/tipo-pago')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $tiposDePago = DB::table('tipo_pago')
                ->select('id','nombre')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('tipo_pago')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $tiposDePago,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoPago $tipo_pago)
    {
        return view('administrar.tipo-pago.edit',['tipoPago'=>$tipo_pago]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoPago $tipo_pago)
    {
        $rules = [
            'nombre' => 'required'
        ];

        $this->validate($request, $rules);

        $tipo_pago->nombre = $request->nombre;
        $tipo_pago->save();

        return redirect('/tipo-pago')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoPago $tipo_pago)
    {
        try {
            $tipo_pago->delete();

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

    public function obtenerTipoPago(){

        $tipoPago = TipoPago::select('id','nombre')->get();

        return response()->json(['data' => $tipoPago],200);
    }
}
