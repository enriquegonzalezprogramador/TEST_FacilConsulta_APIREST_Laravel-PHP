<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Medico;

class Paciente extends Model
{
       use HasFactory;


    protected $table = 'pacientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'nome', 'cpf', 'celular'
    ];

    protected $hidden = ['pivot'];


    public function medicos()
    {
        return $this->belongsToMany(Medico::class, 'medicos_pacientes');
    }
}
