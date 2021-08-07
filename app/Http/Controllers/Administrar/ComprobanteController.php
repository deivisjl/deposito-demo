<?php

namespace App\Http\Controllers\Administrar;

use App\Comprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ComprobanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.comprobante.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.comprobante.create');
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
            'nombre' => 'required',
            'serie' => 'required',
            'cantidad_numeros' => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $comprobante = new Comprobante();
        $comprobante->nombre = $request->nombre;
        $comprobante->serie = strtoupper($request->serie);
        $comprobante->cantidad_numeros = $request->cantidad_numeros;
        $comprobante->save();

        return redirect('/comprobantes')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre","serie","cantidad_numeros");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $comprobantes = DB::table('comprobante')
                ->select('id','nombre','serie','cantidad_numeros')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('comprobante')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $comprobantes,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function edit(Comprobante $comprobante)
    {
        return view('administrar.comprobante.edit',['comprobante' => $comprobante]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comprobante $comprobante)
    {
        $rules = [
            'nombre' => 'required',
            'serie' => 'required',
            'cantidad_numeros' => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $comprobante->nombre = $request->nombre;
        $comprobante->serie = strtoupper($request->serie);
        $comprobante->cantidad_numeros = $request->cantidad_numeros;
        $comprobante->save();

        return redirect('/comprobantes')->with(['mensaje' => 'Actualización exitosa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comprobante $comprobante)
    {
        try {
            $comprobante->delete();

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
}
