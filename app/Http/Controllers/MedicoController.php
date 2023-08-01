<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MedicoController extends Controller
{
        public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 
        // Retornar una respuesta JSON con todos los medicos encontrados ordenados por creacion
            $medicos = Medico::orderBy('created_at', 'desc')->with('cidade','pacientes')->paginate(5);

        // Retornar una respuesta JSON con todos los medicos encontrados
         return response()->json(['medicos' => $medicos], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            //validaciones 

            $customMessages = [
                'required' => 'El campo :attribute es obligatorio.',
                'numeric' => 'El campo :attribute debe ser numérico.',
                // Agrega aquí más mensajes personalizados para otras reglas de validación.
            ];

                     $validator = Validator::make($request->all(), [
                        'nome' => 'required',
                        'especialidade' => 'required',
                        'cidade_id' => 'required'
                    ],$customMessages);

                 if ($validator->fails()) {

                    $errors = $validator->errors()->all();
                     return response()->json(['errors' => $errors], 422);
                }

        try {
            DB::beginTransaction();

            // Crear una nueva instancia del modelo con los datos recibidos
            $medico = new Medico();
            $medico->nome = $request->input('nome');
            $medico->especialidade = $request->input('especialidade');
            $medico->cidade_id = $request->input('cidade_id');
            // Asignar otros campos si es necesario


            // Guardar el nuevo recurso en la base de datos
            $medico->save();

            DB::commit();

            // Retornar una respuesta JSON con el recurso creado y código de estado 201
            return response()->json(['medico' => $medico], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Si ocurre un error, retornar una respuesta JSON con el mensaje de error y código de estado 500 
            return response()->json(['message' => 'Error al crear el recurso'], 500);
        }
    }

    }


