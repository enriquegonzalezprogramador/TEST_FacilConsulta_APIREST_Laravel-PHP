<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cidade;
use App\Models\Paciente;

class Medico extends Model
{
        use HasFactory;


    protected $table = 'medicos';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
       'nome', 'especialidade','cidade_id'
    ];

    protected $hidden = ['cidade_id'];

    public function cidade () {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

        public function pacientes()
    {
        return $this->belongsToMany(Paciente::class, 'medicos_pacientes');
    }

}
