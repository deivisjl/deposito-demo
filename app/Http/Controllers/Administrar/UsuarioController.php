<?php

namespace App\Http\Controllers\Administrar;

use App\Rol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();

        return view('administrar.usuario.create',['roles' => $roles]);
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
            "nombres" => 'required|string|max:100',
            "apellidos" => 'required|string|max:100',
            "dpi" => 'required|string|max:100|unique:users',
            "telefono" => 'required|numeric|min:1',
            "direccion" => 'required|string',
            "correo" => 'required|string|max:100|unique:users,email',
            "password" => 'required|string|min:5|confirmed',
            "rol" => 'required|numeric|min:1'
        ];

        $this->validate($request, $rules);

        $usuario = new User();
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->dpi = $request->dpi;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->email = $request->correo;
        $usuario->password = bcrypt($request->password);
        $usuario->rol_id = $request->rol;
        $usuario->save();

        return redirect('/usuarios')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("u.id","u.nombres","u.dpi","u.telefono","u.email","r.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];


        $usuarios = DB::table('users as u')
                ->join('rol as r','u.rol_id','r.id')
                ->select('u.id',DB::raw("CONCAT_WS(' ',u.nombres,'',u.apellidos) as nombre"),'u.dpi','u.telefono','u.email','r.nombre as rol')
                ->whereNull('u.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('users as u')
                ->join('rol as r','u.rol_id','r.id')
                ->whereNull('u.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $usuarios,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $roles = Rol::all();

        return view('administrar.usuario.edit',['usuario' => $usuario,'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $rules = [
            "nombres" => 'required|string|max:100',
            "apellidos" => 'required|string|max:100',
            "dpi" => 'required|string|max:100|unique:users,dpi,'.$usuario->id,
            "telefono" => 'required|numeric|min:1',
            "direccion" => 'required|string',
            "correo" => 'required|string|max:100|unique:users,email,'.$usuario->id,
            "rol" => 'required|numeric|min:1'
        ];

        $this->validate($request, $rules);

        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->dpi = $request->dpi;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->email = $request->correo;
        $usuario->rol_id = $request->rol;
        $usuario->save();

        return redirect('/usuarios')->with(['mensaje' => 'Actualización exitosa']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        try
        {
            if($usuario->id == Auth::user()->id )
            {
                throw new \Exception("No se puede eliminar el usuario en sesión");
            }

            $usuario->delete();

            return response()->json(['data' => 'El registro se eliminó con éxito'],200);
        }
        catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    public function miAcceso(){
        return view('administrar.usuario.credencial');
    }

    public function miAccesoActualizar(Request $request){
        $rules = [
            "password" => 'required|string|min:5|confirmed',
        ];

        $this->validate($request, $rules);

        $usuario = Auth::user();
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return redirect('/')->with(['mensaje' => 'Contraseña actualizada con éxito']);
    }
}
