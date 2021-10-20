<?php

namespace App\Http\Controllers\Reportes;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteDocumentoController extends Controller
{
    private $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes.documentos.index');
    }

    public function ReporteDocumentoCompra(Request $request)
    {
        try
        {
            $desde = Carbon::parse($request->get('desde'));
            $hasta = Carbon::parse($request->get('hasta'));

            if($desde >= $hasta)
            {
                throw new \Exception("Debe seleccionar un rango válido", 1);
            }

            $diferencia = $hasta->diffInDays($desde);

            if($diferencia > 365)
            {
                throw new \Exception("El rango no debe ser mayor a un año", 1);
            }

            $registros = DB::table('compra as c')
                            ->join('proveedor as p','c.proveedor_id','p.id')
                            ->select('c.id','c.no_comprobante','c.monto','c.fecha_comprobante as fecha_emision','p.nombre','c.created_at')
                            ->whereBetween('c.created_at',[$desde,$hasta])
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-compra',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function ReporteDocumentoVenta(Request $request)
    {
        try
        {
            $desde = Carbon::parse($request->get('desde'));
            $hasta = Carbon::parse($request->get('hasta'));

            if($desde >= $hasta)
            {
                throw new \Exception("Debe seleccionar un rango válido", 1);
            }

            $diferencia = $hasta->diffInDays($desde);

            if($diferencia > 365)
            {
                throw new \Exception("El rango no debe ser mayor a un año", 1);
            }

            $registros = DB::table('venta as v')
                            ->join('cliente as c','c.id','v.cliente_id')
                            ->select('v.id','v.no_factura','v.monto',DB::raw("CONCAT_WS(' ',c.nombres,'',c.apellidos) as cliente"),'v.created_at')
                            ->whereBetween('c.created_at',[$desde,$hasta])
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-venta',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function ReporteDocumentoInventario()
    {
        try
        {
            $registros = DB::table('producto as p')
                            ->join('categoria as c','p.categoria_id','c.id')
                            ->select('p.id','p.stock','p.nombre','c.nombre as categoria',DB::raw('ROUND(((p.precio_promedio*p.porcentaje_ganancia)/100) + p.precio_promedio,2) as precio'))
                            ->get();

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-inventario',['registros' => $registros,])->setPaper('letter','landscape');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function ReporteDocumentoVentaMes(Request $request)
    {
        try
        {
            $desde = Carbon::parse($request->get('desde'));
            $hasta = Carbon::parse($request->get('hasta'));

            if($desde >= $hasta)
            {
                throw new \Exception("Debe seleccionar un rango válido", 1);
            }

            $diferencia = $hasta->diffInDays($desde);

            if($diferencia > 365)
            {
                throw new \Exception("El rango no debe ser mayor a un año", 1);
            }

            $registros = DB::table('venta')
                        ->select(DB::raw('SUM(monto) as monto'),DB::raw("TO_CHAR(created_at,'mm-yyyy') as mes"))
                        ->whereBetween('created_at', [$desde, $hasta])
                        ->groupBy(DB::raw("TO_CHAR(created_at,'mm-yyyy')"))
                        ->orderBy(DB::raw("TO_CHAR(created_at,'mm-yyyy')"),'desc')
                        ->get();

            $meses = $this->parsearMeses($registros);

            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('reporte-venta-mes',['registros' => $meses, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','portrait');

            return $reporte->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
    public function parsearMeses($data)
    {
        $respuesta = array();

        foreach ($data as $key => $item)
        {
            $fecha = $item->mes;

            $numero = explode("-",$fecha);

            if($numero[0] < 10)
            {
                $numero2 = explode("0",$numero[0]);
            }
            else
            {
                $numero2[1] = $numero[0];
            }

            $respuesta[$key] = array('mes' => $this->meses[$numero2[1]].' '.$numero[1], 'monto' => (float)$item->monto);
        }

        return $respuesta;
    }
}
