<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validaciones 

             $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        try {
            DB::beginTransaction();

 
            $user = new user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));

            $user->save();

            DB::commit();


            return response()->json(['user' => $user], 201);
        } catch (\Exception $e) {
            DB::rollBack();

           
            return response()->json(['message' => 'Error al crear el recurso'], 500);
        }
    }

   
}
