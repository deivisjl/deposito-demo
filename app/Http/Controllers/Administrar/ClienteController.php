<?php

namespace App\Http\Controllers\Administrar;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.cliente.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.cliente.create');
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
            'apellido' => 'required',
            'nit' => 'nullable|string|unique:cliente',
            'direccion' => 'required',
        ];

        $this->validate($request, $rules);

        $cliente = new Cliente();
        $cliente->nombres = $request->nombre;
        $cliente->apellidos = $request->apellido;
        $cliente->nit = $request->nit;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return redirect('/clientes')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombres","nit");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $clientes = DB::table('cliente')
                ->select('id','nombres','apellidos','nit','direccion')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('cliente')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $clientes,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view('administrar.cliente.edit',['cliente' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'nit' => 'nullable|string|unique:cliente,nit,'.$cliente->id,
            'direccion' => 'required',
        ];

        $this->validate($request, $rules);

        $cliente->nombres = $request->nombre;
        $cliente->apellidos = $request->apellido;
        $cliente->nit = $request->nit;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return redirect('/clientes')->with(['mensaje' => 'Actualización exitosa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();

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

    public function obtenerClientes(){

        $clientes = Cliente::select('id',DB::raw("CONCAT_WS(' ',nombres,'',apellidos,'-',nit) as nombre"))->get();

        return response()->json(['data' => $clientes],200);
    }
}
