<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MedicoPaciente extends Pivot
{

	 protected $table = 'medicos_pacientes';

	 protected $hidden = ['pivot'];

}
