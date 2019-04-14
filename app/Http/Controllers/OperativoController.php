<?php
/**
 * Created by PhpStorm.
 * User: MYSERVER
 * Date: 13/04/2019
 * Time: 16:15
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Cargo;
use Exception;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Operativo;

class OperativoController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        try{
            $listado =  DB::table('operativo')
                ->join('cargo', 'operativo.idcargo', '=', 'cargo.id')
                ->select('operativo.*', 'cargo.carnombre')
                ->get();
            return response()->json($listado,Response::HTTP_OK);

        }catch (Exception $ex){
            return response()->json([
            'error' => 'Hubo un error al listar todos los operativos: '. $ex->getMessage()
        ], 206);
    }
    }

    public function show(Request $request, $id)
    {
        try{
            $operativo = Operativo::find($id);
            return response()->json($operativo);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al encontrar el operativo con id => '. $id ." : ". $ex->getMessage()
            ], 404);
        }
    }


    public function store(Request $request)
    {
        try{
            $operativo = Operativo::create($request->all());
            return response()->json($operativo, Response::HTTP_CREATED);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al registrar el operativo: '. $ex->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $operativo= Operativo::findOrFail($id);
            $operativo->update($request->all());
            return response()->json($operativo,Response::HTTP_OK);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al actualizar el operativo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }


    public function destroy(Request $request, $id)
    {
        try{
            Operativo::find($id)->delete();
            return response()->json([],Response::HTTP_OK);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al eliminar el operativo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }
}