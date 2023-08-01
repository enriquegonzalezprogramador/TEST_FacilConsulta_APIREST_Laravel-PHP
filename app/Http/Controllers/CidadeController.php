<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Http\Requests\StoreCidadesRequest;
use App\Http\Requests\UpdateCidadesRequest;

class CidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retornar una respuesta JSON con todos las cidades encontrados ordenados por creacion
            $cidades = Cidade::orderBy('created_at', 'desc')->paginate(5);

        // Retornar una respuesta JSON con todos las ciudades encontrados
         return response()->json(['cidades' => $cidades], 200);
    }

}
