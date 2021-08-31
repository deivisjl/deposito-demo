<?php

namespace App\Http\Controllers\Administrar;

use App\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.proveedor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.proveedor.create');
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
            'nit' => 'nullable|string|unique:proveedor',
            'telefono' => 'required|numeric',
            'direccion' => 'required|string'
        ];

        $this->validate($request, $rules);

        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->nit = $request->nit;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        return redirect('/proveedores')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre","nit","telefono");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $proveedores = DB::table('proveedor')
                ->select('id','nombre','nit','telefono')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('proveedor')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $proveedores,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedore)
    {
        return view('administrar.proveedor.edit',['proveedor' => $proveedore]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedore)
    {
        $rules = [
            'nombre' => 'required',
            'nit' => 'nullable|string|unique:proveedor,nit,'.$proveedore->id,
            'telefono' => 'required|numeric',
            'direccion' => 'required|string'
        ];

        $this->validate($request, $rules);

        $proveedore->nombre = $request->nombre;
        $proveedore->nit = $request->nit;
        $proveedore->telefono = $request->telefono;
        $proveedore->direccion = $request->direccion;
        $proveedore->save();

        return redirect('/proveedores')->with(['mensaje' => 'Actualización exitosa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedore)
    {
        try {
            $proveedore->delete();

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

    public function obtenerProveedores(){

        $proveedores = Proveedor::select('id',DB::raw("CONCAT_WS(' ',nombre,'-',nit) as nombre"))->get();

        return response()->json(['data' => $proveedores],200);
    }
}
