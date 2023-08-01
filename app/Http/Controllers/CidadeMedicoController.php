<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if (!empty($request->route('cidade')) && is_numeric($request->route('cidade'))) {

            $cidade_id = $request->route('cidade');

        try {

        $medicos = Cidade::findOrFail($cidade_id)->with('medicos')->paginate(5);

        // Retornar una respuesta JSON con todos los medicos encontrados
         return response()->json(['medicos' => $medicos], 200);
        
        } catch (\Exception $e) {
         

            return response()->json(['message' => 'Recurso no encontrado'], 404);
        }

    }else {
        return response()->json(['message' => 'Parametro de busqueda no permitido'], 404);
    }

    

    }
}
