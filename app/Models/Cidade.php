<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Medico;

class Cidade extends Model
{
    use HasFactory;


    protected $table = 'cidades';


    protected $fillable = [
       'nome', 'estado'
    ];


    public function medicos() {
        return $this->hasMany(Medico::class);
    }
}
