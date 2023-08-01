<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retornar una respuesta JSON con todos los pacientes encontrados ordenados por creacion
            $pacientes = Paciente::orderBy('created_at', 'desc')->paginate(5);

        // Retornar una respuesta JSON con todos los pacientes encontrados
         return response()->json(['pacientes' => $pacientes], 200);
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
                        'cpf' => 'required',
                        'celular' => 'required'
                    ],$customMessages);

                 if ($validator->fails()) {

                    $errors = $validator->errors()->all();
                     return response()->json(['errors' => $errors], 422);
                }

        try {
            DB::beginTransaction();

            // Crear una nueva instancia del modelo con los datos recibidos
            $paciente = new Paciente();
            $paciente->nome = $request->input('nome');
            $paciente->cpf = $request->input('cpf');
            $paciente->celular = $request->input('celular');
            // Asignar otros campos si es necesario

            // Guardar el nuevo recurso en la base de datos
            $paciente->save();

            DB::commit();

            // Retornar una respuesta JSON con el recurso creado y código de estado 201
            return response()->json(['paciente' => $paciente], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Si ocurre un error, retornar una respuesta JSON con el mensaje de error y código de estado 500 
            return response()->json(['message' => 'Error al crear el paciente'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

            if (!empty($request->route('paciente')) && is_numeric($request->route('paciente'))) {

                    $paciente_id = $request->route('paciente');

                
                      //validaciones 

                    $customMessages = [
                        'required' => 'El campo :attribute es obligatorio.',
                        'numeric' => 'El campo :attribute debe ser numérico.',
                        // Agrega aquí más mensajes personalizados para otras reglas de validación.
                    ];

                             $validator = Validator::make($request->all(), [
                                'nome' => 'required',
                                'cpf' => 'required',
                                'celular' => 'required'
                            ],$customMessages);

                         if ($validator->fails()) {

                            $errors = $validator->errors()->all();
                             return response()->json(['errors' => $errors], 422);
                        }

                try {
                    DB::beginTransaction();

                    $paciente = Paciente::find($paciente_id);

                        if (!$paciente) {
                            // Si el recurso no existe, retornar un mensaje de error con código de estado 404 
                            return response()->json(['message' => 'Paciente no encontrado'], 404);
                        }

                    $paciente->nome = $request->input('nome');
                    $paciente->cpf = $request->input('cpf');
                    $paciente->celular = $request->input('celular');

                    // Actualizar el nuevo recurso en la base de datos
                    $paciente->save();

                    DB::commit();

                     // Retornar una respuesta JSON con el recurso actualizado y código de estado 200 
                        return response()->json(['paciente' => $paciente], 200);
                } catch (\Exception $e) {
                    DB::rollBack();

                    // Si ocurre un error, retornar una respuesta JSON con el mensaje de error y código de estado 500 
                    return response()->json(['message' => 'Error al actualizar el paciente'], 500);
                }

         }else {
            return response()->json(['message' => 'Parametro de busqueda no permitido'], 404);
        }
    }

}
