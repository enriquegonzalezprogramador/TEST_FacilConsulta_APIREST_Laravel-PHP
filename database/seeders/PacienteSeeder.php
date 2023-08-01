<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            $cpf_fake = strval($faker->numberBetween(1111111111, 999999999));
            $mobile_fake = strval($faker->phoneNumber);
            DB::table('pacientes')->insert([
                'nome' => $faker->name,
                'cpf' => $cpf_fake,
                'celular' => $mobile_fake,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
