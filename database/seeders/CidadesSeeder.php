<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cidade;

class CidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 

            $estados = [
            'Sao Paulo',
            'Santa Catarina',
            'Parana',
            'Mato Grosso',
            'Mato Grosso do soul',
            'Amazonas',
            'Rio Grande do Soul'
        ];

            $cidades = [[  'Guarulhos','Santos'
            ],['Florianopolis','Blumenau'],
            ['Foz de iguaçu', 'curitiba'],
            ['Campo Grande'],
            ['Dourados','Fatima do Soul'],
            ['Manaus'],
            ['Porto Alegre']
          
        ];


                for ($i=0; $i < count($estados); $i++) {

                    for ($j=0; $j < count($cidades[$i]); $j++) {

                            $cidade = new Cidade();
                            $cidade->nome = utf8_encode(ucwords(strtolower($cidades[$i][$j])));
                            $cidade->estado = utf8_encode(ucwords(strtolower($estados[$i])));
                             $cidade->save();  

                   }
               }

    }
}
