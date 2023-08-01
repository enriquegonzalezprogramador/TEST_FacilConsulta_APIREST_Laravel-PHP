<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Medico;
use App\Models\Cidade;

class MedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            $cidade_random = Cidade::inRandomOrder()->first();
            DB::table('medicos')->insert([
                'nome' => $faker->name,
                'especialidade' => $faker->sentence,
                'cidade_id' => $cidade_random->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
