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


class CargoController
{
    public function __construct()
    {

    }

    public function index(){
        try{
            $listado = Cargo::all();
            return response()->json($listado,Response::HTTP_OK);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al listar todos los cargos: '. $ex->getMessage()
            ], 206);
        }
    }

    public function show(Request $request,$id)
    {
        try{
            $cargo = Cargo::find($id);
            return response()->json($cargo,Response::HTTP_OK);
        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al encontrar el cargo con id => '. $id ." : ". $ex->getMessage()
            ], 404);
        }
    }


    public function store(Request $request)
    {
        try{
            $cargo = Cargo::create($request->all());
            return response()->json($cargo, Response::HTTP_CREATED);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al registrar el cargo: '. $ex->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $cargo= Cargo::findOrFail($id);
            $cargo->update($request->all());
            return response()->json($cargo,Response::HTTP_OK);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al actualizar el cargo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
            Cargo::find($id)->delete();
            return response()->json([],Response::HTTP_OK);

        }catch (Exception $ex){
            return response()->json([
                'error' => 'Hubo un error al eliminar el cargo con id => '.$id." : ". $ex->getMessage()
            ], 400);
        }
    }

}