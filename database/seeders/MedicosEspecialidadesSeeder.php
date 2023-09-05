<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicosEspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicosEspecialidades = [
            [
                'medico_id' => 1,
                'especialidade_id' => 2
            ],
            [
                'medico_id' => 2,
                'especialidade_id' => 1
            ],
            [
                'medico_id' => 3,
                'especialidade_id' => 4
            ],
            [
                'medico_id' => 4,
                'especialidade_id' => 5
            ],
            [
                'medico_id' => 5,
                'especialidade_id' => 3
            ],
            [
                'medico_id' => 1,
                'especialidade_id' => 4
            ],
            [
                'medico_id' => 4,
                'especialidade_id' => 1
            ]
        ];

        DB::table('medicos_especialidades')->insert($medicosEspecialidades);
    }
}
