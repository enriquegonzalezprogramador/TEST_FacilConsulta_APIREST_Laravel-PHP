<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MedicoPacienteController extends Controller
{

	    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if (!empty($request->route('medico')) && is_numeric($request->route('medico'))) {

            $medico_id = $request->route('medico');

        try {

        $pacientes = Medico::findOrFail($medico_id)->with('pacientes')->paginate(5);

        // Retornar una respuesta JSON con todos los medicos encontrados
         return response()->json(['pacientes' => $pacientes], 200);
        
        } catch (\Exception $e) {
         

            return response()->json(['message' => 'Recurso no encontrado'], 404);
        }

    }else {
        return response()->json(['message' => 'Parametro de busqueda no permitido'], 404);
    }

    

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    	  if (!empty($request->route('medico')) && is_numeric($request->route('medico'))) {

	            $medico_id = $request->route('medico');



	           //validaciones 

	            $customMessages = [
	                'required' => 'El campo :attribute es obligatorio.',
	                'numeric' => 'El campo :attribute debe ser numérico.',
	                // Agrega aquí más mensajes personalizados para otras reglas de validación.
	            ];

	                     $validator = Validator::make($request->all(), [
	           				 'paciente_id' => 'required|exists:pacientes,id',
	                    ],$customMessages);

	                 if ($validator->fails()) {

	                    $errors = $validator->errors()->all();
	                     return response()->json(['errors' => $errors], 422);
	                }

	        try {
	            DB::beginTransaction();

	            $medico = Medico::find($medico_id);
	            $paciente = Paciente::find($request->input('paciente_id'));

	            // Verificar si la relación ya existe para evitar duplicados
	            if ($medico && $paciente && !$medico->pacientes->contains($paciente)) {
	                $medico->pacientes()->attach($paciente->id);
	                DB::commit();

	                // Retornar una respuesta JSON con el mensaje de éxito y código de estado 201 (CREATED)
	                return response()->json(['message' => 'Se ha assignado el paciente exitosamente.'], 201);
	            }

	            DB::rollBack();

	            // Si la relación ya existe o no se encontró el usuario o rol, retornar una respuesta JSON con el mensaje de error y código de estado 400 
	            return response()->json(['message' => 'La asignacion ya existe o no se encontró el medico o paciente.'], 400);
	        } catch (\Exception $e) {
	            DB::rollBack();

	            // Si ocurre un error, retornar una respuesta JSON con el mensaje de error y código de estado 500
	            return response()->json(['message' => 'Error al crear la relación'], 500);
	        }

       }
    }

}
